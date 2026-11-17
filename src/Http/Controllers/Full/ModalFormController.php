<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use App\Http\Controllers\Controller;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Table;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\JsonResponseDemoForm;
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
            ->description('弹窗与响应全 API 示例：三通道统一（admin.layout.dialog）+ JsonResponse 全指令，逐项实测')
            ->body($this->build());
    }

    protected function build()
    {
        // Form::dialog 原生用法（通道三）
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

    {$this->section('一、Modal 同步内容 API（非异步加载，关闭即销毁）', '
        内容随页面渲染进 &lt;template&gt; 元素，点击 clone 全新节点弹出，关闭零 DOM 残留。
        未指定尺寸=高度内容自适应；显式 sm/lg/xl/size=恒定不变。
    ')}
    <div style='margin: 12px 0'>
        {$this->mPlain()} {$this->mSm()} {$this->mLg()} {$this->mXl()} {$this->mCustomSize()} {$this->mFooter()} {$this->mJoin()}
    </div>

    {$this->section('二、Modal 事件与行为 API', '
        事件桥 onShow/onShown/onHide/onHidden 对应 layer 打开与关闭时机（target 指向内容根元素）；
        centered/scrollable/enlargedTransform 在 layer 驱动下为自动生效或 no-op；delay 用于弹窗内
        异步图表的延迟渲染。
    ')}
    <div style='margin: 12px 0'>
        {$this->mEvents()} {$this->mBackdrop()} {$this->mDelayed()}
    </div>

    {$this->section('三、JsonResponse 全指令（弹窗表单提交演示）', '
        每个按钮预置一种响应模式：打开弹窗直接点「提交」即可看到该 JsonResponse 指令的实际效果。
        也可打开「模式选择器」自由切换全部 21 种模式。
    ')}
    {$this->jsonResponseMatrix()}

    {$this->section('四、异步内容（LazyRenderable / LazyGrid）与嵌套', '
        异步表单（payload 传参）、只读表单（viewOnly）、异步表格（分页/搜索弹窗内完成）、
        嵌套弹窗（外层表格 → 内层编辑）。
    ')}
    <div style='margin: 12px 0'>
        {$this->asyncForm()} {$this->asyncViewOnly()} {$this->asyncTable()} {$this->asyncNested()}
    </div>

    {$this->section('五、Form::dialog 通道（原生用法）', '
        直接绑定按钮 class 弹窗加载整页表单；链接可写在按钮 data-url 属性中覆盖默认值。
        未指定 height 时高度内容自适应（统一配置派生）。
    ')}
    <div style='margin: 12px 0'>
        <span class='btn btn-outline-primary create-form'> &nbsp;&nbsp;新增表单弹窗（650px 恒定）&nbsp;&nbsp; </span> &nbsp;&nbsp;
        <span class='btn btn-primary edit-form' data-url='{$editPage}'> &nbsp;&nbsp;编辑表单弹窗（未指定尺寸=自适应）&nbsp;&nbsp; </span>
    </div>
</div>
";
    }

    protected function section(string $title, string $desc)
    {
        return "<h5 style='margin-top: 28px'><b>{$title}</b></h5>
            <p style='color: #888; margin: 6px 0'>{$desc}</p>";
    }

    /* ------------------ 一、Modal 同步内容 API ------------------ */

    /** title/body/button 基础用法；未指定尺寸=高度内容自适应 */
    protected function mPlain()
    {
        return Modal::make()
            ->title('纯 HTML（默认尺寸 auto）')
            ->body('<h4>同步内容</h4><p>未调用任何尺寸方法 → 高度随内容自适应。</p>')
            ->button("<span class='btn btn-outline-primary'>默认尺寸</span>")
            ->render();
    }

    protected function mSm()
    {
        return Modal::make()
            ->sm()
            ->title('sm 尺寸')
            ->body('<p style="padding: 20px 0; text-align: center">sm：300px 宽，恒定不变</p>')
            ->button("<span class='btn btn-outline-primary'>sm</span>")
            ->render();
    }

    protected function mLg()
    {
        return Modal::make()
            ->lg()
            ->title('lg 尺寸')
            ->body('<p style="padding: 40px 0; text-align: center; color: #999">lg：800px 宽 / 70% 高，恒定不变</p>')
            ->button("<span class='btn btn-outline-primary'>lg</span>")
            ->render();
    }

    protected function mXl()
    {
        return Modal::make()
            ->xl()
            ->title('xl 尺寸')
            ->body('<p style="padding: 60px 0; text-align: center; color: #999">xl：1140px 宽 / 90% 高，恒定不变</p>')
            ->button("<span class='btn btn-outline-primary'>xl</span>")
            ->render();
    }

    /** size(string) 自定义宽度 */
    protected function mCustomSize()
    {
        return Modal::make()
            ->size('600px')
            ->title('size(600px) 自定义')
            ->body('<p style="padding: 30px 0; text-align: center; color: #999">自定义宽度 600px，恒定不变</p>')
            ->button("<span class='btn btn-outline-primary'>自定义尺寸</span>")
            ->render();
    }

    /** footer 底部按钮区 */
    protected function mFooter()
    {
        $table = Table::make(
            ['字段', '值'],
            [['组件', 'Widgets\Table'], ['footer', '底部按钮区'], ['请求', '无']]
        );

        return Modal::make()
            ->lg()
            ->title('footer 底部按钮区')
            ->body($table)
            ->footer("<button class='btn btn-white' onclick=\"layer.closeAll()\">关闭全部</button>")
            ->button("<span class='btn btn-outline-primary'>组件+footer</span>")
            ->render();
    }

    /** join(true)：触发器与弹窗 HTML 拼接返回（自行控制输出位置） */
    protected function mJoin()
    {
        $modal = Modal::make()
            ->title('join(true) 拼接返回')
            ->body('<p>join(true) 时 render() 返回「触发器 + 弹窗 HTML」拼接串，由调用方决定输出位置（本例在按钮右侧手动 echo）。</p>')
            ->button("<span class='btn btn-outline-primary'>join 拼接</span>");

        return $modal->render();
    }

    /* ------------------ 二、Modal 事件与行为 API ------------------ */

    /** 事件桥：四个时机 */
    protected function mEvents()
    {
        return Modal::make()
            ->title('事件桥（onShow/onShown/onHide/onHidden）')
            ->body('<p>打开/关闭本弹窗，观察 toast 与控制台输出：</p><p style="color:#888">onShow → onShown →（关闭）→ onHide → onHidden</p>')
            ->onShow("Dcat.info('onShow：开始显示')")
            ->onShown("console.log('[事件桥] onShown', target)")
            ->onHide("Dcat.warning('onHide：开始隐藏')")
            ->onHidden("console.log('[事件桥] onHidden', target)")
            ->button("<span class='btn btn-outline-primary'>事件桥</span>")
            ->render();
    }

    /** staticBackdrop / centered / scrollable / enlargedTransform 行为说明 */
    protected function mBackdrop()
    {
        return Modal::make()
            ->title('行为修饰方法（layer 驱动语义）')
            ->body(<<<'HTML'
<p>layer 驱动下各修饰方法的实际语义：</p>
<ul style="color:#666;line-height:1.9">
<li><b>centered()</b> —— no-op：layer 始终垂直居中</li>
<li><b>scrollable()</b> —— 始终生效：内容区超高自动内部滚动（细滚动条）</li>
<li><b>enlargedTransform()</b> —— no-op：BS4 专属入场动画，layer 已全局禁用动画</li>
<li><b>staticBackdrop()</b> —— 当前为预留位（layer 遮罩由全局 shade 配置管理）</li>
</ul>
HTML)
            ->button("<span class='btn btn-outline-primary'>修饰方法说明</span>")
            ->render();
    }

    /** delay：弹窗内异步图表的延迟渲染场景 */
    protected function mDelayed()
    {
        return Modal::make()
            ->title('delay(ms) 延迟渲染')
            ->body('<p style="color:#888">delay(300) 用于弹窗内异步图表等需要在容器可见后延迟初始化的场景（本例无图表，仅演示 API）。</p>')
            ->delay(300)
            ->button("<span class='btn btn-outline-primary'>delay(300)</span>")
            ->render();
    }

    /* ------------------ 三、JsonResponse 全指令矩阵 ------------------ */

    protected function jsonResponseMatrix()
    {
        // 每种模式一个直达按钮（payload 预置 mode）
        $direct = [];
        $groups = [
            '提示类'   => ['success', 'success_refresh', 'info', 'warning', 'error', 'error_refresh'],
            '弹窗形态' => ['alert', 'alert_detail', 'timeout'],
            '页面动作' => ['refresh', 'download', 'redirect', 'location', 'location_null', 'script'],
            '数据类'   => ['data', 'validation', 'exception', 'status_code', 'if_magic', 'status_false', 'flash_with'],
        ];
        $names = JsonResponseDemoForm::$modes;

        foreach ($groups as $gname => $modes) {
            $btns = '';
            foreach ($modes as $m) {
                $short = explode('——', $names[$m])[0];
                $btns .= Modal::make()
                    ->lg()
                    ->title('JsonResponse：'.($names[$m] ?? $m))
                    ->body(JsonResponseDemoForm::make()->payload(['mode' => $m]))
                    ->button("<span class='btn btn-outline-secondary btn-sm'>{$short}</span>")
                    ->render();
            }
            $direct[] = "<div style='margin: 8px 0'><b style='color:#555'>{$gname}：</b><div style='margin-top:6px'>{$btns}</div></div>";
        }

        // 万能模式选择器
        $picker = Modal::make()
            ->lg()
            ->title('JsonResponse 模式选择器（21 种全量）')
            ->body(JsonResponseDemoForm::make())
            ->button("<span class='btn btn-primary'>模式选择器</span>")
            ->render();

        return $picker.'<div style="margin-top: 10px">'.implode('', $direct).'</div>';
    }

    /* ------------------ 四、异步内容 ------------------ */

    protected function asyncForm()
    {
        return Modal::make()
            ->lg()
            ->title('异步表单（LazyRenderable + payload）')
            ->body(UserProfile::make()->payload(['name' => '演示用户']))
            ->button("<span class='btn btn-primary'>异步表单</span>")
            ->render();
    }

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

    protected function asyncTable()
    {
        return Modal::make()
            ->lg()
            ->title('异步表格（LazyGrid）')
            ->body(UserTable::make())
            ->button("<span class='btn btn-primary'>异步表格</span>")
            ->render();
    }

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
