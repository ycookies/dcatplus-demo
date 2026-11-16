<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Callout;

class FixedController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('Fixed Column')
            ->description('表格固定列功能示例')
//            ->body(Callout::make('即将在下个版本发布，敬请期待~'))
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(new Report(), function (Grid $grid) {
            $grid->showColumnSelector();

            $grid->column('name');
            $grid->column('content')->limit(50);
            $grid->column('cost')->sortable();
            $grid->column('avgQuarterCost')->setHeaderAttributes(['style' => 'color:#5b69bc']);
            $grid->column('avgYearCost');
            $grid->column('avgMonthVist');
            $grid->column('avgQuarterVist');
            $grid->column('avgYearVist');
            $grid->column('incrs');
            $grid->column('avgVists');
            $grid->column('date')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->tools($this->buildPreviewButton());

            // 启用边框模式
//            $grid->withBorder();
            // $grid->setActionClass(Grid\Displayers\DropdownActions::class);
            // $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->fixColumns(2);
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                // $actions->disableDelete(); //  禁用删除
                // $actions->disableEdit();   //  禁用修改
                // $actions->disableQuickEdit(); //禁用快速修改(弹窗形式)
                // $actions->disableView(); //  禁用查看
            });

            //$grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableCreateButton();
        });
    }
}
