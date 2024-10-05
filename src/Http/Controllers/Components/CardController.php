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
use Dcat\Admin\Widgets\Card;
use Illuminate\Routing\Controller;

class CardController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('普通卡片')
            ->breadcrumb(
                ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
                ['text' => '页面组件', 'url' => '/dcatplus-demo/full-widget'],
                ['text' => '普通卡片']
            )
            ->row($this->buildPreviewButton().$this->newline())
            ->row(function (Row $row) {
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->outline());
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->setCardColor());
                $row->column(3, Card::make('标题','内容')->withHeaderBorder());
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->outline('card-warning'));
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->outline('card-success')->footer('这是尾部'));
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->tool('<span class="badge badge-pill badge-primary">123</span>'));
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->collapse());
                $row->column(3, Card::make('标题','内容')->withHeaderBorder()->remove());

            });

    }
}
