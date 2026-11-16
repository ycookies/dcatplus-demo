<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Illuminate\Support\Facades\Storage;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use App\Http\Controllers\Controller;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\Carousel;
use Faker\Factory;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Alert;
class CarouselController extends Controller
{
    public function index(Content $content)
    {

        $carousel = Carousel::make()
                            ->interval(3);   // 每张停顿 1 秒
                            //->vertical();   // 垂直滚动；默认是 horizontal()

        $datalist   = [
            [
                'img_src' => Storage::url('images/banner/1.jpeg'),
                'title'     => '拼多多助新老用户力瓶多多砍',
                'content'   => '多多砍一刀xi推金币现金大转盘一单十人助成拼多多助新老用户力瓶多多砍一刀xi推金币现金大转盘一',
                'link'      => '',
            ],
            [
                'img_src' => Storage::url('images/banner/2.jpeg'),
                'title'     => '自动发货养号秒发秒评手机图片可爱萌萌哒壁纸',
                'content'   => '可爱萌萌哒壁纸一分钱壁纸0.01元自动发货养号秒发秒评手机图片',
                'link'      => '',
            ]
        ];
        foreach ($datalist as $key => $items) {
            $carousel->add($items['img_src'],$items['title'], $items['content'], $items['link']);
        }

        $htmls = <<<HTML
        <ul>
        <li>可以控制区块大小</li>
        </ul>
HTML;

        $content->row(Callout::make($htmls, '轮播组件说明')->primary());

        $carousel2 = Carousel::make()->interval(3)->vertical()->addItems($datalist)->arrows(false);
        // 
        $content->row(function (Row $row) use ($carousel, $carousel2) {
            $row->column(6, $carousel->render());
            $row->column(6, $carousel2->render());
        });


        $header = 'Carousel';
        // 添加面包屑导航
        $content->breadcrumb(
            ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
            ['text' => '页面组件', 'url' => '/dcatplus-demo/full-widget'],
            ['text' => 'Carousel']
        );

        return $content->header($header);
    }
}
