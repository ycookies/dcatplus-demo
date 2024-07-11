<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Linkbox;
use Dcat\Admin\Widgets\ListGroup;
use Dcat\Admin\Widgets\Timeline;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Routing\Controller;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\CoverCard;

class DcatplusDemoController extends Controller {
    public function index(Content $content) {
        $page = $content
            ->title('Dcat-plus 示例大全')
            ->description('本示例一切的努力，只为降低您的学习成本,留更多的空闲时间去悠然的享受生活');

        $alert = Alert::make('<code> Dcat-plus Admin </code> 是基于dcat-admin 的功能增强版，主要是加强两方面，加强灵活的布局; 丰富更多的页面组件。以及修正原有的一些问题。最终做成 汇聚Filament，Laravel-admin , Dcat-admin 优点于一身的基于Laravel +Bootstrap 的极速开发框架。', '说明');

        $page->row($alert->info());
        $page->row(function (Row $row) {
            $row->column(4, function (Column $column) {
                $column->row(Card::make('作者展示', Admin::view('ycookies.dcatplus-demo::author')));
            });
            $row->column(8, function (Column $column) {
                $column->row(function (Row $row) {
                    $cover_card = CoverCard::make()->add('开源公众号','关注公众号 随时了解更新动态')
                        ->bg('https://dcat-plus.saishiyun.net/img/card-bg1.jpeg')
                        ->avatar('https://dcat-plus.saishiyun.net/img/wxgzh_qrcode.jpg');
                    $row->column(6, $cover_card->render());

                    $cover_card1 = CoverCard::make()->add('赞助捐助开源','鼓励作者持续更新')
                        ->bg('https://dcat-plus.saishiyun.net/img/card-bg2.jpeg')
                        ->avatar('https://dcat-plus.saishiyun.net/img/weixinpay.jpg');
                    $row->column(6, $cover_card1->render());
                });

                $list_group = ListGroup::make();
                $datas = [
                    [
                        'title' => '让DcatAdmin再放光芒系列 [页面组件]:上百种页面组件随便加',
                        'datetime'=> '2024-07-10',
                        'link' => 'https://learnku.com/articles/87518',
                    ],[
                        'title' => '如何让DcatAdmin再放光芒,惠及百万PHPer',
                        'datetime'=> '2024-07-08',
                        'link' => 'https://learnku.com/articles/87439',
                    ],[
                        'title' => 'dcat-admin 按钮上打开日历 选择日期',
                        'datetime'=> '2024-07-03',
                        'link' => 'https://learnku.com/articles/86568',
                    ],[
                        'title' => 'dcat-admin多应用后台 高效实现免密登陆其它后台',
                        'datetime'=> '2024-07-01',
                        'link' => 'https://learnku.com/articles/86140',
                    ]
                ];

                foreach ($datas as $keys => $items) {
                    $list_group->add($items['title'], $items['datetime'],$items['link']);
                }

                $column->row(Card::make('Dcatplus 动态', $list_group->render()));
                $timeline = Timeline::make();
                $htmls2 = <<<HTML
                <ul>
                <li>列表组vue版，时间轴vue版</li>
                <li>并展示vue使用方法</li>
</ul>
HTML;
                $timeline->add('2024-07-10','更新发布2种实用页面组件','12:58',$htmls2)->icons('fa fa-get-pocket bg-blue');

                $htmls = <<<HTML
                <ul>
                <li>Dcatplus Admin 全部实用的示例展示</li>
                <li>实用的各种页面组件样例展示，可以直观选择学习使用</li>
</ul>
HTML;

                $timeline->add('','首次发布,让使用Dcatplus admin 更简单高效','08:10',$htmls);
                $column->row(Card::make('扩展包-更新日志', $timeline->render())->withHeaderBorder());
            });
        });
        return $page;
    }
}