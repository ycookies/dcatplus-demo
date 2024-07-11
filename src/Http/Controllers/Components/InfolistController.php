<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use App\Http\Controllers\Controller;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\InfoList;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Alert;


class InfolistController extends Controller
{
    public function index(Content $content)
    {

        $infolist = new InfoList();

        $datalist   = [
            [
                'img_src' => 'https://rails365.oss-cn-shenzhen.aliyuncs.com/uploads/slide/image/4/2021/007596a025ecf51207c13eda90d04508.png',
                'title'     => '拼多多助新老用户力瓶多多砍',
                'content'   => '多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一',
                'link'      => 'https://item.taobao.com/item.htm?spm=a21n57.1.item.3.292d3296QUdish&priceTId=2147803217198867233631501e8b91&utparam=%7B%22aplus_abtest%22:%22d7258a6c6dd5973cd59f4666ad9d216a%22%7D&id=809526386726&ns=1&abbucket=12',
            ],
            [
                'img_src' => 'https://rails365.oss-cn-shenzhen.aliyuncs.com/uploads/slide/image/4/2021/007596a025ecf51207c13eda90d04508.png',
                'title'     => '自动发货养号秒发秒评手机图片可爱萌萌哒壁纸',
                'content'   => '可爱萌萌哒壁纸一分钱壁纸0.01元自动发货养号秒发秒评手机图片',
                'link'      => '',
            ]
        ];
        foreach ($datalist as $key => $items) {
            $infolist->add($items['img_src'],$items['title'], $items['content'], $items['link']);
        }

        $htmls = <<<HTML
        <ul>
        <li>可以控制区块大小</li>
        </ul>
HTML;

        $content->row(Callout::make($htmls, '信息列表组件 说明')->primary());
        $content->row(Card::make('信息列表(infolist)', $infolist->render()));


        $header = '信息列表';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
