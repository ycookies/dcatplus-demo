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
use Dcat\Admin\Widgets\Carousel;
use Dcat\Admin\Widgets\ListGroup;
//use Faker\Factory;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;

class ListGroupController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {



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

        //$faker = Factory::create();
        $content->row($this->buildPreviewButton().$this->newline());
        $content->row(Card::make('列表组(list-group)', $list_group->render()));
        $header = 'list-group';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
