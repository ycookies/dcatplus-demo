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
use Dcat\Admin\Widgets\Collapse;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;

class CollapseController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {

        $collapse = new Collapse();

        $collapse->add('Bar', 'xxxxx');
        $collapse->add('Orders', '这是第二个');
        $collapse->add('这是第3个标题', '这是第3个');
        $collapse->add('这是第4个标题', '这是第4个');
        $collapse->add('这是第5个标题', '这是第5个');
        $collapse->render();
        //$faker = Factory::create();
        $content->row($this->buildPreviewButton().$this->newline());
        $content->row(Card::make('折叠组件(Collapse)', $collapse->render()));


        $header = 'Collapse';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
