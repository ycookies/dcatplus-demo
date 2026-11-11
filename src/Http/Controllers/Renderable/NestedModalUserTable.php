<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\UserProfile;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Models\Administrator;

/**
 * 嵌套弹窗测试：外层（本表格所在的异步表格弹窗）内再开内层表单弹窗.
 *
 * 用于实测 Bootstrap 嵌套 modal 补丁（五死因：z-index/fade 回调/dismiss
 * 冒泡/onShow 误触/stacking context）。验证点：
 * 1. 点行内「弹窗编辑」内层正常打开（不"一闪就关"）
 * 2. 内层遮罩只盖外层弹窗，不遮全屏
 * 3. 点内层关闭按钮只关内层，外层不受影响
 * 4. 内层能正常关闭（不卡 _isTransitioning）
 * 5. 提交内层表单：成功提示 + 智能局部刷新外层
 */
class NestedModalUserTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new Administrator(), function (Grid $grid) {
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
            $grid->disableActions();
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('username')->width(4);
                $filter->like('name')->width(4);
            });
        });
    }
}
