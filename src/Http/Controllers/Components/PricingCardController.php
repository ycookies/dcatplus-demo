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
use Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Forms\AdminSetting;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\PricingCard;


class PricingCardController extends Controller
{
    use PreviewCode;
    public function index(Content $content)
    {



        $pricing_card = PricingCard::make();
        $pricing_card->columns(3); // 控制几列
        //$pricing_card->isCenter(); // li 内容是否居中
        $user_id = Admin::user()->id;
        $paysurlqrcode = 'https://cgai.saishiyun.net/wxpay/?price_code=squThzt4vP&user_code='.urlencode(base64_encode($user_id));

        $urls = 'https://modstart.saishiyun.net/api/aigc_tools/getVerPayQrcode?pay_url_qrcode='.urlencode($paysurlqrcode);
        $pricing_card->btnClick($urls); // 点击事件 获取支付二维码

        $pricing_card->add('免费','0')
            ->li(['常用功能-12'=>true,'常用功能-13'=>false,'常用功能-14'=>false,'常用功能-15'=>false,'常用功能-16'=>false])
            ->head('3人坐席');

        $pricing_card->add('会员版',89)
            ->li(['常用功能-12'=>true,'常用功能-13'=>true,'常用功能-14'=>false,'常用功能-15'=>false,'常用功能-16'=>false])
            ->head('10人坐席')
            ->footer("<span class='text-danger'>超级优惠，快速订阅</span>")
            ->active()
            ->btnTxt('订购 (超优惠)');

        $pricing_card->add('企业版',289)
            ->li(['常用功能-12'=>true,'常用功能-13'=>true,'常用功能-14'=>true,'常用功能-15'=>true,'常用功能-16'=>false])
            ->head('100人坐席');

        $pricing_card->add('专业版',589)
            ->li(['常用功能-12'=>true,'常用功能-13'=>true,'常用功能-14'=>true,'常用功能-15'=>true,'常用功能-16'=>true])
            ->head('1000人坐席');

        $htmls = <<<HTML
        <ul>
        <li>控制列数 pricing_card->columns(3)</li>
        <li>控制li 内容是否居中 pricing_card->isCenter()</li>
        </ul>
HTML;
        $content->row(Callout::make($htmls, '定价卡 说明')->primary());
        $content->row($this->buildPreviewButton() . $this->newline());

        $content->row(Card::make('定价卡(pricing-card)', $pricing_card->render()));


        $header = '定价卡';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
