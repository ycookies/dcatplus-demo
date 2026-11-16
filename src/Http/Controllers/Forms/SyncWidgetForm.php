<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Traits\LazyWidget;

/**
 * 异步工具表单（Widgets\Form + LazyRenderable）示例.
 *
 * 与 UserProfile 的区别：本表单类同时实现 LazyRenderable——弹窗以异步
 * 通道打开（关闭即销毁，每次点击重新请求最新内容，组件脚本由
 * resolveHtml 重放），提交走 dcat-api/form 端点（隐藏域 _form_ 携带
 * 类名自动分发，无需注册路由），AJAX 由 Dcat.Form 驱动（_token 自动
 * 携带）。
 *
 * 保存成功后所在弹层自动关闭，随后按 then 指令分发：
 * refresh 整页重载 / 无指令只提示。
 */
class SyncWidgetForm extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle(array $input): JsonResponse
    {
        if (empty($input['keyword'])) {
            return $this->error('关键字不能为空');
        }

        // 实际业务写在这里（如 TelegramServices::deleteMenu($input['keyword'])）
        // 演示：无落库，直接成功并整页刷新（去掉 ->refresh() 则只提示不刷新）
        return $this->success('已处理：'.$input['keyword'])->refresh();
    }

    public function form()
    {
        $this->text('keyword', '关键字')->required()->help('演示字段，提交后原样回显');
        $this->textarea('remark', '备注')->rows(2);
    }
}
