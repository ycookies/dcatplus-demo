<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\Markdown;
use Illuminate\Contracts\Support\Renderable;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Models\Menu as MenuModel;

class DataDetailController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        $description = '<code>演示数据信息展示</code> ';

        $alert = Alert::make($description, '说明')->info();

        $show = Show::make(2, new MenuModel(), function (Show $show) {

            $show->field('hotel_bd');
            $show->field('hotel_name');
            $show->field('doc_link')->links('查看');
            $show->field('business_code');
            $show->field('mch_id');
            $show->field('subject_type');
            $show->field('finance_institution');
            $show->field('license_copy');
            //$show->field('license_number');
            //$show->field('merchant_name');
            $show->fields(['license_number','merchant_name']);
            $show->field('legal_person');
            $show->field('license_address');
            $show->field('period_begin');
            $show->field('period_end');
            $show->field('id_holder_type');
            $show->field('id_doc_type');
            $show->field('id_card_copy');
            $show->field('id_card_national');
            $show->field('id_card_name');
            $show->field('id_card_number');
            $show->field('id_card_address');
            $show->field('contact_id_card_name');
            $show->field('contact_id_card_number');
            $show->field('contact_id_card_address');
            $show->field('contact_card_period_begin');
            $show->field('contact_card_period_end');
            $show->field('card_period_begin');
            $show->field('card_period_end');
            $show->field('contact_id_doc_copy');
            $show->field('contact_id_card_national');
            $show->field('mobile_phone');
            $show->field('contact_email');
            $show->field('merchant_shortname');
            $show->field('service_phone');
            $show->field('province_id');
            $show->field('city_id');
            $show->field('district_id');
            $show->field('biz_address_code');
            $show->field('biz_store_address');
            $show->field('store_entrance_pic');
            $show->field('indoor_pic');
            $show->field('settlement_id');
            $show->field('qualification_type');
            $show->field('bank_account_type');
            $show->field('account_bank');
            $show->field('account_name');
            $show->field('bank_province_id');
            $show->field('bank_city_id');
            $show->field('bank_district_id');
            $show->field('bank_address_code');
            $show->field('account_number');
            $show->field('jinjian_status');
            $show->field('status');
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableListButton();
            $show->disableDeleteButton();
            $show->disableEditButton();
            //$show->showQuickEdit();
        });

        return $content->header('Post')
            ->description('数据详情')
             ->row('<div style="margin:5px 0 15px;">'.$this->buildPreviewButton().'</div>')
            ->row($alert.$show->render());
    }
}
