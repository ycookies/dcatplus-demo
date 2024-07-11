<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Linkbox;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Str;


class FullWidgetController extends Controller {

    public function index(Content $content) {

        $description = '<code>开发提速</code> 持续上线后台需要的各类实用页面组件。<br/>';

        $alert = Alert::make($description, '说明')->info();

        return $content->header('百种组件')
            ->description('专注为后台开发提速')
            ->body($alert . $this->pageMain());
    }

    public function pageMain() {
        $req  = Request()->all();
        $type = request('_t', 1);
        $tab  = Tab::make();
        $tab->add('各类实用页面组件', $this->tab0());
        return $tab->withCard();
    }

    // 订房相关
    public function tab0() {


        $link_group = [
            [
                'icon'      => 'feather icon-chevrons-down',
                'title'     => 'Collapse',
                'sub_title' => '列表信息折叠',
                'link'      => '/admin/dcatplus-demo/components/collapse',
                'bg_value'  => 'bg-info',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-fw fa-th-list',
                'title'     => 'List-group',
                'sub_title' => '列表组',
                'link'      => '/admin/dcatplus-demo/components/list-group',
                'bg_value'  => 'bg-success',
                'hot'       => false,
            ], [
                'icon'      => 'feather icon-shield',
                'title'     => 'Btn-group',
                'sub_title' => '按钮组',
                'link'      => '/admin/dcatplus-demo/components/btn-group',
                'bg_value'  => 'bg-warning',
                'hot'       => false,
            ], [
                'icon'      => 'feather icon-film',
                'title'     => 'Media-list',
                'sub_title' => '媒体列表',
                'link'      => '/admin/dcatplus-demo/components/media-list',
                'bg_value'  => 'bg-danger',
                'hot'       => true,
            ], [
                'icon'      => 'feather icon-image',
                'title'     => 'Carousel',
                'sub_title' => '轮播图',
                'link'      => '/admin/dcatplus-demo/components/carousel',
                'bg_value'  => 'bg-primary',
                'hot'       => true,
            ], [
                'icon'      => 'fa fa-money',
                'title'     => 'Pricing-card',
                'sub_title' => '定价卡',
                'link'      => '/admin/dcatplus-demo/components/pricing-card',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-calendar-times-o',
                'title'     => 'Timeline',
                'sub_title' => '时间轴',
                'link'      => '/admin/dcatplus-demo/components/timeline',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-file-text-o',
                'title'     => 'Infolist',
                'sub_title' => '信息列表',
                'link'      => '/admin/dcatplus-demo/components/infolist',
                'bg_value'  => 'bg-secondary',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-id-card-o',
                'title'     => 'card-widget',
                'sub_title' => '用户卡片挂件',
                'link'      => '/admin/dcatplus-demo/components/card-widget',
                'bg_value'  => 'bg-info',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-credit-card',
                'title'     => 'Cover-Card',
                'sub_title' => 'cover-card',
                'link'      => '/admin/dcatplus-demo/components/cover-card',
                'bg_value'  => 'bg-primary',
                'hot'       => false,
            ]

        ];

        $linkbox = new Linkbox();
        $linkbox->groupTitle('新增组件 <span class="text-danger f14">('.count($link_group).' 种)</span>');
        $linkbox->target('_blank');

        foreach ($link_group as $key => $itemk) {
            $linkbox->add($itemk['icon'], $itemk['title'], $itemk['sub_title'], $itemk['link'], $itemk['bg_value'])->hot($itemk['hot']);
        }

        /**
         * [
        'icon'      => 'fa fa-navicon',
        'title'     => 'Navbar',
        'sub_title' => 'navbar',
        'link'      => '/admin/dcatplus-demo/components/navbar',
        'bg_value'  => 'bg-danger',
        'hot'       => true,
        ],
         */

        $link_group2 = [
            [
                'icon'      => 'fa fa-line-chart',
                'title'     => 'metric-cards',
                'sub_title' => '数据统计卡片',
                'link'      => '/admin/dcatplus-demo/components/metric-cards',
                'bg_value'  => 'bg-success',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-clone',
                'title'     => 'Modal',
                'sub_title' => 'modal',
                'link'      => '/admin/dcatplus-demo/components/modal',
                'bg_value'  => 'bg-warning',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-list-ol',
                'title'     => 'Dropdown',
                'sub_title' => 'dropdown',
                'link'      => '/admin/dcatplus-demo/components/dropdown-menu',
                'bg_value'  => 'bg-primary',
                'hot'       => true,
            ], [
                'icon'      => 'fa fa-btc',
                'title'     => 'Tab & Button',
                'sub_title' => 'tab & button',
                'link'      => '/admin/dcatplus-demo/components/tab-button',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-check-square-o',
                'title'     => 'Checkbox & Radio',
                'sub_title' => 'checkbox & radio',
                'link'      => '/admin/dcatplus-demo/components/checkbox-radio',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-circle-o-notch',
                'title'     => 'Alert & Callout',
                'sub_title' => 'alert & callout',
                'link'      => '/admin/dcatplus-demo/components/alert',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-trademark',
                'title'     => 'Markdown',
                'sub_title' => 'markdown',
                'link'      => '/admin/dcatplus-demo/components/markdown',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-info-circle',
                'title'     => 'Tooltip',
                'sub_title' => 'tooltip',
                'link'      => '/admin/dcatplus-demo/components/tooltip',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ], [
                'icon'      => 'fa fa-spin fa-circle-o-notch',
                'title'     => 'Loading',
                'sub_title' => 'loading',
                'link'      => '/admin/dcatplus-demo/components/loading',
                'bg_value'  => 'bg-dark',
                'hot'       => false,
            ]

        ];
        $linkbox2 = new Linkbox();
        $linkbox2->groupTitle('Dcat原有组件 <span class="text-danger f14">('.count($link_group2).' 种)</span>');
        $linkbox2->target('_blank');

        foreach ($link_group2 as $key => $itemk) {
            $linkbox2->add($itemk['icon'], $itemk['title'], $itemk['sub_title'], $itemk['link'], $itemk['bg_value'])->hot($itemk['hot']);
        }

        $card = Card::make('', $linkbox2->render() . $linkbox->render());
        return $card;
    }


}
