<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\UserProfile;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Models\Administrator;

/**
 * 嵌套弹窗测试 + 异步表格启用 Create/Actions 完整方案.
 *
 * 【为什么异步表格默认没有 Create / Actions】
 *
 * 1. CreateButton「被默认禁用」是刻意设计：列 ->modal() 弹窗表格走
 *    Modal::content() → LazyTable->simple() → payload _simple_=1 →
 *    Grid\LazyRenderable::prepare() 在简化模式下自动
 *    disableCreateButton()/disablePerPages()/disableBatchDelete()/
 *    disableRefreshButton()（弹窗里塞完整工具栏太挤）。
 *
 * 2. Actions「开了也用不了」：Grid 构造时 resource() 默认取当前请求
 *    PATH（异步请求是 admin/dcat-api/render），行操作的
 *    编辑/删除/查看链接会拼成 admin/dcat-api/render/{id}/edit 这类
 *    错误 URL → 404。
 *
 * 【解决方案（两行核心代码）】
 *
 * 1. $grid->setResource('auth/users')           显式指定资源路径（注意：
 *    Grid::resource() 是只读 getter，传参会被静默丢弃，必须用
 *    setResource，内部自动 admin_url() 包裹），Actions/Create 的
 *    URL 立即正确；
 * 2. $grid->showCreateButton()                  重新打开创建按钮
 *    （showCreateButton = disableCreateButton(false)）。
 *
 * 行为说明：编辑/查看为整页跳转（离开弹窗上下文）；删除为 AJAX；
 * QuickEdit 为弹窗内再开弹窗——依赖 v3.0.16/v2.0.33 起的嵌套 modal
 * 补丁（五死因 + 筛选面板冒泡第六死因）才能在异步表格内正常使用。
 */
class NestedModalUserTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new Administrator(), function (Grid $grid) {
            // ★ 核心方案：显式资源路径 + 重新打开创建按钮
            // （注意：resource() 是只读 getter，必须用 setResource）
            $grid->setResource('auth/users');
            $grid->showCreateButton();

            $grid->column('id', 'ID')->sortable();
            $grid->column('username');
            $grid->column('name');
            $grid->column('created_at');

            $grid->quickSearch(['id', 'username', 'name']);

            // 内层弹窗：外层表格弹窗的 modal-body 内再打开表单弹窗
            $grid->column('_nested_modal', '嵌套弹窗')
                ->display('弹窗编辑')
                ->modal(function (Grid\Displayers\Modal $modal) {
                    $modal->title('内层表单弹窗（嵌套测试）');
                    $modal->icon('feather icon-layers');

                    return UserProfile::make()->payload(['name' => $this->name]);
                });

            $grid->paginate(10);
            //$grid->disableActions();
            //$grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('username')->width(4);
                $filter->like('name')->width(4);
            });
        });
    }
}
