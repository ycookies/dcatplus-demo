<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use App\Http\Controllers\Controller;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Form as WidgetForm;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Widgets\Table;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\SyncWidgetForm;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\UserProfile;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\NestedModalUserTable;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;

class ModalFormController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('Modal Form')
            ->description('弹窗全场景示例：同步内容 / 异步内容 / Form::dialog 三种通道全覆盖（layer 驱动）')
            ->body($this->build());
    }

    protected function build()
    {
        Form::dialog('新增角色')
            ->click('.create-form')
            ->url('auth/roles/create')
            ->width('700px')
            ->height('650px')
            ->success('LA.reload()');

        Form::dialog('编辑角色')
            ->click('.edit-form')
            ->success('Dcat.reload()');

        $editPage = admin_base_path('auth/roles/1/edit');

        return "
<div style='padding: 20px 0'>
    {$this->buildPreviewButton()}

    {$this->section('一、同步内容（非异步加载）', '
        内容随页面一次性渲染进隐藏容器，点击后整体搬入弹层（元素身份不变，
        弹窗内交互页面加载时已绑定）。高度默认自适应，关闭后可反复打开。
    ')}
    <div style='margin: 12px 0'>
        {$this->syncPlainHtml()} {$this->syncInteractive()} {$this->syncWidgetFooter()} {$this->syncXl()} {$this->syncEvents()} {$this->syncWidgetForm()}
    </div>

    {$this->section('二、异步内容（LazyRenderable / LazyGrid）', '
        点击时以 renderable URL 为内容源异步加载（_dialog_form_ 最小化渲染），
        提交由 layer 底部按钮驱动，保存后按 JsonResponse 指令分发
        （refresh/download/location/script…无指令只提示不刷新）。
    ')}
    <div style='margin: 12px 0'>
        {$this->asyncForm()} {$this->asyncViewOnly()} {$this->asyncTable()} {$this->asyncNested()}
    </div>

    {$this->section('三、Form::dialog 通道（原生用法）', '
        直接绑定按钮 class 弹窗加载整页表单；链接可写在按钮 data-url 属性中覆盖默认值。
    ')}
    <div style='margin: 12px 0'>
        <span class='btn btn-outline-primary create-form'> &nbsp;&nbsp;新增表单弹窗&nbsp;&nbsp; </span> &nbsp;&nbsp;
        <span class='btn btn-primary edit-form' data-url='{$editPage}'> &nbsp;&nbsp;编辑表单弹窗&nbsp;&nbsp; </span>
    </div>
</div>
";
    }

    protected function section(string $title, string $desc)
    {
        return "<h5 style='margin-top: 28px'><b>{$title}</b></h5>
            <p style='color: #888; margin: 6px 0'>{$desc}</p>";
    }

    /**
     * 1. 纯 HTML 同步内容：默认尺寸，高度自适应.
     */
    protected function syncPlainHtml()
    {
        return Modal::make()
            ->title('纯 HTML 同步内容')
            ->body('<h4>同步内容弹窗</h4><p>这段内容随页面渲染，没有发起任何异步请求。</p><p>高度随内容自适应（同 Bootstrap modal 行为）。</p>')
            ->button("<span class='btn btn-outline-primary'>纯 HTML</span>")
            ->render();
    }

    /**
     * 2. keepAlive 复用式：关闭归位、状态延续（元素身份保持）.
     *
     * 默认销毁式（其余示例）：关闭即销毁、页面零 DOM 残留、重复打开
     * 每次都是初始状态。需要跨开关保留状态或依赖页面加载时脚本绑定的
     * 内容（工具表单、图表等）才开启本项.
     */
    protected function syncInteractive()
    {
        return Modal::make()
            ->keepAlive()
            ->title('同步内容 · keepAlive 复用式')
            ->body("<p>本弹窗开启了 <code>keepAlive()</code>：反复【关闭再打开】计数不归零"
                ."（同一 DOM 节点复用，关闭只是归位隐藏）：</p>"
                ."<button class='btn btn-primary btn-sm' onclick=\"var n=(this.dataset.n=(+this.dataset.n||0)+1);"
                ."this.innerText='点了 '+n+' 次'\">点我计数</button>")
            ->button("<span class='btn btn-outline-primary'>keepAlive 复用</span>")
            ->render();
    }

    /**
     * 3. 组件内容 + footer：普通 Renderable（Widgets\\Table）同步渲染，带底部按钮区.
     */
    protected function syncWidgetFooter()
    {
        $table = Table::make(
            ['字段', '值'],
            [['类型', 'Widgets\\Table 组件'], ['渲染时机', '随页面同步渲染'], ['请求', '无']]
        );

        return Modal::make()
            //->lg()
            ->title('同步内容 · 组件 + footer')
            ->body($table)
            ->footer("<button class='btn btn-white' onclick=\"layer.closeAll()\">知道了</button>")
            ->button("<span class='btn btn-outline-primary'>组件+footer</span>")
            ->render();
    }

    /**
     * 4. xl 大尺寸：显式档位时宽高用映射值（1140px / 90%）.
     */
    protected function syncXl()
    {
        return Modal::make()
            ->xl()
            ->title('同步内容 · xl 大尺寸')
            ->body('<p style="padding: 40px 0; text-align: center; color: #999">xl 弹窗（1140px 宽 / 90% 高）——适合大段说明、对比表格等场景</p>')
            ->button("<span class='btn btn-outline-primary'>xl 尺寸</span>")
            ->render();
    }

    /**
     * 6. 同步工具表单：Widgets\\Form 带 handle 的表单类内联渲染（TelegramMenuDelete 同款模式）.
     *
     * 提交自动走 dcat-api/form 端点分发到 handle()（无需注册路由，_token
     * 自动携带）；成功后所在弹层自动关闭，再按 then 指令分发
     * （refresh 整页重载 / 无指令只提示）；失败弹窗保留供修改重试。
     */
    protected function syncWidgetForm()
    {
        return Modal::make()
            ->keepAlive()
            ->title('同步内容 · 工具表单（Widgets\Form + handle）')
            ->body(SyncWidgetForm::make())
            ->button("<span class='btn btn-outline-primary'>同步表单</span>")
            ->render();
    }

    /**
     * 5. 事件桥：onShow/onShown → 打开时机；onHide/onHidden → 关闭时机.
     *    脚本内 target/body 指向内容根元素（与 BS4 时代语义兼容）.
     */
    protected function syncEvents()
    {
        return Modal::make()
            ->title('同步内容 · 事件桥')
            ->body('<p>打开/关闭本弹窗，观察右上角 toast 与控制台输出：</p><p style="color:#888">onShow → onShown →（关闭）→ onHide → onHidden</p>')
            ->onShow("Dcat.info('onShow：开始显示')")
            ->onShown("console.log('[事件桥] onShown', target)")
            ->onHide("Dcat.warning('onHide：开始隐藏')")
            ->onHidden("console.log('[事件桥] onHidden', target)")
            ->button("<span class='btn btn-outline-primary'>事件桥</span>")
            ->render();
    }

    /**
     * 6. 异步表单：LazyRenderable 表单类（lg），payload 传上下文.
     */
    protected function asyncForm()
    {
        return Modal::make()
            ->lg()
            ->title('异步表单（LazyRenderable）')
            ->body(UserProfile::make()->payload(['name' => '演示用户']))
            ->button("<span class='btn btn-primary'>异步表单</span>")
            ->render();
    }

    /**
     * 7. 只读表单：viewOnly 隐藏提交/重置，纯查看.
     */
    protected function asyncViewOnly()
    {
        return Modal::make()
            ->lg()
            ->title('只读表单（viewOnly）')
            ->viewOnly(true)
            ->body(UserProfile::make()->payload(['name' => '只读演示']))
            ->button("<span class='btn btn-primary'>只读表单</span>")
            ->render();
    }

    /**
     * 8. 异步表格：LazyGrid（Grid\LazyRenderable），分页/搜索弹窗内完成.
     */
    protected function asyncTable()
    {
        return Modal::make()
            ->lg()
            ->title('异步表格（LazyGrid）')
            ->body(UserTable::make())
            ->button("<span class='btn btn-primary'>异步表格</span>")
            ->render();
    }

    /**
     * 9. 嵌套弹窗：外层异步表格内，行操作再开内层弹窗（layer 天然多层叠加）.
     */
    protected function asyncNested()
    {
        return Modal::make()
            ->xl()
            ->title('嵌套弹窗（外层表格 → 内层表单）')
            ->body(NestedModalUserTable::make())
            ->button("<span class='btn btn-primary'>嵌套弹窗</span>")
            ->render();
    }
}
