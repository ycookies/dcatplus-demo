<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\GoalOverview;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewDevices;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewUsers;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\ProductOrders;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\Sessions;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\Tickets;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\TotalUsers;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Routing\Controller;

class MetricCardController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('数据统计卡片')
            ->breadcrumb(
                ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
                ['text' => '页面组件', 'url' => '/dcatplus-demo/full-widget'],
                ['text' => '数据统计卡片']
            )
            ->body($this->buildPreviewButton().$this->newline())
            ->body(function (Row $row) {
                $row->column(4, new TotalUsers());
                $row->column(4, new NewUsers());
                $row->column(4, new NewDevices());
            })
            ->body(function (Row $row) {
                $row->column(6, new Sessions());
                $row->column(6, new ProductOrders());
            })
            ->body(function (Row $row) {
                $row->column(6, new Tickets());
                $row->column(4, new GoalOverview());
            });
    }
}
