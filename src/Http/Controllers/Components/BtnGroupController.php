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
use Dcat\Admin\Widgets\BtnGroup;
use Faker\Factory;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;

class BtnGroupController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {

        $group = new BtnGroup();

        $group->add('第1个', 'fa fa-cc-diners-club');
        $group->add('第2个', 'fa fa-cc-jcb');
        $group->add('第3个', 'fa fa-chrome');
        $group->add('第4个', 'fa fa-clone');

        $group2 = new BtnGroup();
        $group2->vertical();
        $group2->add('第1个', 'fa fa-cc-diners-club');
        $group2->add('第2个', 'fa fa-cc-jcb');
        $group2->add('第3个', 'fa fa-chrome');
        $group2->add('第4个', 'fa fa-clone');

        //$faker = Factory::create();
        $content->row($this->buildPreviewButton().$this->newline());
        $content->row(Card::make('按钮组(btn-group)', $group->render()));

        $content->row(Card::make('按钮组(btn-group)', $group2->render()));
        $header = 'btn-group';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
