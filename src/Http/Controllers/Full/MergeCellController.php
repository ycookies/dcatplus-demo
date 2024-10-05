<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewDevices;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewUsers;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\TotalUsers;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;

class MergeCellController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('报表')
            ->description('合并单元格')
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(new Report(), function (Grid $grid) {
            //$grid->showColumnSelector();
            //$grid->column('content')->limit(50);
            $grid->withBorder(); // 让表格显示边框
            $grid->column('room_name')->width('140')->setAttributes(['mergeRows'=> '1']);
            $grid->column('cost')->sortable();
            /*$grid->column('avgMonthCost');
            $grid->column('avgQuarterCost')->setHeaderAttributes(['style' => 'color:#5b69bc']);
            $grid->column('avgYearCost');
            $grid->column('avgMonthVist');*/
            $grid->column('avgQuarterVist');
            $grid->column('avgYearVist');
            $grid->column('incrs')->hide();
            $grid->column('avgVists')->hide();
            $grid->column('date')->sortable();

            // 开启responsive插件
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();

            $grid->rowSelector()->style('success')->click();

            $grid->tools($this->buildPreviewButton());

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
