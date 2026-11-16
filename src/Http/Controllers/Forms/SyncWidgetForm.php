<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Http\JsonResponse;

/**
 * 同步内容弹窗内的工具表单（Widgets\Form 带 handle）示例.
 *
 * 与 LazyRenderable 异步表单的区别：本表单随页面一次性渲染（Modal 同步
 * 通道），提交走 dcat-api/form 端点（隐藏域 _form_ 携带类名自动分发，
 * 无需注册路由），AJAX 由 Dcat.Form 驱动（_token 自动携带）。
 *
 * 保存成功后所在弹层自动关闭（Modal 内置钩子），随后按 then 指令分发：
 * refresh 整页重载 / 无指令只提示。
 */
class SyncWidgetForm extends Form
{
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
