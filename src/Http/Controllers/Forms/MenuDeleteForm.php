<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Form;

/**
 * 同步内容弹窗内的工具表单（Widgets\Form 带 handle）示例
 * （TelegramMenuDelete 同款模式：普通 Widgets\Form + handle，无
 * LazyRenderable）.
 *
 * 表单随页面一次性渲染（Modal 同步通道，隐藏容器承载），提交走
 * dcat-api/form 端点（隐藏域 _form_ 携带类名自动分发，无需注册路由），
 * AJAX 由 Dcat.Form 驱动（_token 自动携带）。
 *
 * 保存成功后所在弹层自动关闭，随后按 then 指令分发：
 * refresh 整页重载 / 无指令只提示。
 */
class MenuDeleteForm extends Form
{
    public function handle(array $input): JsonResponse
    {
        if (empty($input['menu_keyword'])) {
            return $this->error('关键字不能为空');
        }

        // 实际业务写在这里（如 TelegramServices::deleteMenu($input['menu_keyword'])）
        // 演示：无落库，直接成功（去掉 ->refresh() 则只提示不刷新）
        return $this->success('已处理：'.$input['menu_keyword']);
    }

    public function form()
    {
        $this->text('menu_keyword', '菜单关键字')->required()->help('演示字段，提交后原样回显');
        $this->textarea('menu_remark', '备注')->rows(2);
    }
}
