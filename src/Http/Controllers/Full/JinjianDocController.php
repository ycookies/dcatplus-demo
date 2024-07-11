<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JinjianDocController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SettingModel(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('hotel_bd');
            $grid->column('hotel_name');
            $grid->column('doc_link');
            $grid->column('business_code');
            $grid->column('mch_id');
            $grid->column('subject_type');
            $grid->column('finance_institution');
            $grid->column('license_copy');
            $grid->column('license_number');
            $grid->column('merchant_name');
            $grid->column('legal_person');
            $grid->column('license_address');
            $grid->column('period_begin');
            $grid->column('period_end');
            $grid->column('id_holder_type');
            $grid->column('id_doc_type');
            $grid->column('id_card_copy');
            $grid->column('id_card_national');
            $grid->column('id_card_name');
            $grid->column('id_card_number');
            $grid->column('id_card_address');
            $grid->column('contact_id_card_name');
            $grid->column('contact_id_card_number');
            $grid->column('contact_id_card_address');
            $grid->column('contact_card_period_begin');
            $grid->column('contact_card_period_end');
            $grid->column('card_period_begin');
            $grid->column('card_period_end');
            $grid->column('contact_id_doc_copy');
            $grid->column('contact_id_card_national');
            $grid->column('mobile_phone');
            $grid->column('contact_email');
            $grid->column('merchant_shortname');
            $grid->column('service_phone');
            $grid->column('province_id');
            $grid->column('city_id');
            $grid->column('district_id');
            $grid->column('biz_address_code');
            $grid->column('biz_store_address');
            $grid->column('store_entrance_pic');
            $grid->column('indoor_pic');
            $grid->column('settlement_id');
            $grid->column('qualification_type');
            $grid->column('bank_account_type');
            $grid->column('account_bank');
            $grid->column('account_name');
            $grid->column('bank_province_id');
            $grid->column('bank_city_id');
            $grid->column('bank_district_id');
            $grid->column('bank_address_code');
            $grid->column('account_number');
            $grid->column('jinjian_status');
            $grid->column('status');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new SettingModel(), function (Show $show) {
            $show->field('id');
            $show->field('hotel_bd');
            $show->field('hotel_name');
            $show->field('doc_link');
            $show->field('business_code');
            $show->field('mch_id');
            $show->field('subject_type');
            $show->field('finance_institution');
            $show->field('license_copy');
            $show->field('license_number');
            $show->field('merchant_name');
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
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SettingModel(), function (Form $form) {
            $form->display('id');
            $form->text('hotel_bd');
            $form->text('hotel_name');
            $form->text('doc_link');
            $form->text('business_code');
            $form->text('mch_id');
            $form->text('subject_type');
            $form->text('finance_institution');
            $form->text('license_copy');
            $form->text('license_number');
            $form->text('merchant_name');
            $form->text('legal_person');
            $form->text('license_address');
            $form->text('period_begin');
            $form->text('period_end');
            $form->text('id_holder_type');
            $form->text('id_doc_type');
            $form->text('id_card_copy');
            $form->text('id_card_national');
            $form->text('id_card_name');
            $form->text('id_card_number');
            $form->text('id_card_address');
            $form->text('contact_id_card_name');
            $form->text('contact_id_card_number');
            $form->text('contact_id_card_address');
            $form->text('contact_card_period_begin');
            $form->text('contact_card_period_end');
            $form->text('card_period_begin');
            $form->text('card_period_end');
            $form->text('contact_id_doc_copy');
            $form->text('contact_id_card_national');
            $form->text('mobile_phone');
            $form->text('contact_email');
            $form->text('merchant_shortname');
            $form->text('service_phone');
            $form->text('province_id');
            $form->text('city_id');
            $form->text('district_id');
            $form->text('biz_address_code');
            $form->text('biz_store_address');
            $form->text('store_entrance_pic');
            $form->text('indoor_pic');
            $form->text('settlement_id');
            $form->text('qualification_type');
            $form->text('bank_account_type');
            $form->text('account_bank');
            $form->text('account_name');
            $form->text('bank_province_id');
            $form->text('bank_city_id');
            $form->text('bank_district_id');
            $form->text('bank_address_code');
            $form->text('account_number');
            $form->text('jinjian_status');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
