<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;
use App\Http\Controllers\Controller;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\CoverCard;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Admin;

class CoverCardController extends Controller
{
    use PreviewCode;
    public function index(Content $content)
    {
        $content->row(Callout::make('', 'cover-card 说明')->primary());

        $content->row($this->buildPreviewButton() . $this->newline());
        $content->row(function (Row $row) {
            $row->column(4, function (Column $column) {
                $column->row(Card::make('作者展示', Admin::view('ycookies.dcatplus-demo::author')));
            });
            $row->column(8, function (Column $column) {
                $column->row(function (Row $row) {
                    $cover_card = CoverCard::make()->add('开源公众号', '关注公众号 随时了解更新动态')
                        ->bg('https://dcat-plus.saishiyun.net/img/card-bg1.jpeg')
                        ->avatar('https://dcat-plus.saishiyun.net/img/wxgzh_qrcode.jpg');
                    $row->column(6, $cover_card->render());

                    $cover_card1 = CoverCard::make()->add('赞助捐助开源', '鼓励作者持续更新')
                        ->bg('https://dcat-plus.saishiyun.net/img/card-bg2.jpeg')
                        ->avatar('https://dcat-plus.saishiyun.net/img/weixinpay.jpg');
                    $row->column(6, $cover_card1->render());
                });
            });
        });

        $header = 'cover-Card';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
