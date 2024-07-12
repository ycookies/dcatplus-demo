<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\MediaList;

class MediaListController extends Controller {
    use PreviewCode;

    public function index(Content $content) {

        $media_list = new MediaList();
        $datalist   = [
            [
                'title'     => '拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成',
                'content'   => '拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成.拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成.拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成.拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成.拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成.拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一单十人助成',
                'media_img' => 'https://g-search3.alicdn.com/img/bao/uploaded/i4/i1/1698300612/O1CN01AXcDdy1GOLBapFKgQ_!!1698300612.jpg_460x460q90.jpg',
                'link'      => 'https://item.taobao.com/item.htm?spm=a21n57.1.item.3.292d3296QUdish&priceTId=2147803217198867233631501e8b91&utparam=%7B%22aplus_abtest%22:%22d7258a6c6dd5973cd59f4666ad9d216a%22%7D&id=809526386726&ns=1&abbucket=12',
            ],
            [
                'title'     => '一分钱壁纸0.01元自动发货养号秒发秒评手机图片可爱萌萌哒壁纸',
                'content'   => '一分钱壁纸0.01元自动发货养号秒发秒评手机图片可爱萌萌哒壁纸一分钱壁纸0.01元自动发货养号秒发秒评手机图片可爱萌萌哒壁纸一分钱壁纸0.01元自动发货养号秒发秒评手机图片可爱萌萌哒壁纸一分钱壁纸0.01元自动发货养号秒发秒评手机图片可爱萌萌哒壁纸',
                'media_img' => 'https://g-search1.alicdn.com/img/bao/uploaded/i4/i1/2217906880198/O1CN01SLfRkR1DKjOBs05sx_!!2217906880198.jpg_460x460q90.jpg',
                'link'      => '',
            ]
        ];
        foreach ($datalist as $key => $items) {
            $media_list->add($items['title'], $items['content'], $items['media_img'], $items['link']);
        }
        //$media_list->imgCenter(true); // 图片居中
        $media_list->imgMaxWidth('200px');
        $media_list->rowNum(4);
        //$media_list->target('_blank');
        //$faker = Factory::create();

        $content->row($this->buildPreviewButton() . $this->newline());
        $htmls = <<<HTML
        <ul>
        <li>可以控制图片是否居中 media_list->imgCenter(true)</li>
        <li>可以控制图片大小 media_list->imgMaxWidth('200px')</li>
        <li>可以控制内容简介展示的行数 media_list->rowNum(4)</li>
        <li>可以控制是否是链接</li>
        <li>可以控制链接跳转方式 media_list->target('_blank')</li>
        </ul>
HTML;

        $content->row(Callout::make($htmls, '组件说明')->primary());
        $content->row(Card::make('媒体列表(media_list)', $media_list->render()));


        $header = 'media_list';
        $content->breadcrumb(
            ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
            ['text' => '页面组件', 'url' => '/dcatplus-demo/full-widget'],
            ['text' => 'media list']
        );

        return $content->header($header);
    }
}
