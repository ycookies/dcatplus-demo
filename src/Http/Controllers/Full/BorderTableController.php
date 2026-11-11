<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\UserProfile;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\NestedModalUserTable;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\PostTable;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Callout;

class BorderTableController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('边框模式')
            ->description('边框模式 + 异步加载功能演示')
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(new Report(), function (Grid $grid) {
            $grid->column('name');
            $grid->column('content')->limit(50);
            $grid->column('avgMonthCost')->display('异步表单')
                ->modal('弹窗表单',function (Grid\Displayers\Modal $modal) {
                // 标题
                $modal->title('异步表单');
                // 自定义图标
                $modal->icon('feather icon-edit');

                // 传递当前行字段值
                return UserProfile::make()->payload(['name' => $this->name]);
            });
            $grid->column('avgYearCost')
                ->display('异步表格')
                ->modal('弹窗标题', UserTable::make());
            // 嵌套弹窗测试：外层异步表格弹窗内，行操作再开内层表单弹窗
            // （实测 Bootstrap 嵌套 modal 补丁：z-index/fade/dismiss/onShow/stacking）
            $grid->column('_nested_test', '嵌套弹窗测试')
                ->display('打开外层弹窗')
                ->modal('用户列表（外层弹窗）', NestedModalUserTable::make());
            $grid->column('avgYearVist')->hide();
            $grid->column('incrs');
            $grid->column('date')->sortable();
            $grid->column('created_at');

            $grid->tools($this->buildPreviewButton());

            $grid->tableCollapse(false);

            $grid->withBorder();

            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->scope(1, admin_trans_field('month'))->where('date', 2019, '<=');
                $filter->scope(2, admin_trans_label('quarter'))->where('date', 2019, '<=');
                $filter->scope(3, admin_trans_label('year'))->where('date', 2019, '<=');

                $filter->equal('content');
                $filter->equal('cost');
            });
        });
    }
}
