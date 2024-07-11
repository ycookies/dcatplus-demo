<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\ChaogPartner;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ChaogPartnerController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ChaogPartner(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('position');
            $grid->column('sort');
            $grid->column('title');
            $grid->column('logo');
            $grid->column('link');
            $grid->column('enable');
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
        return Show::make($id, new ChaogPartner(), function (Show $show) {
            $show->field('id');
            $show->field('position');
            $show->field('sort');
            $show->field('title');
            $show->field('logo');
            $show->field('link');
            $show->field('enable');
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
        return Form::make(new ChaogPartner(), function (Form $form) {
            $form->display('id');
            $form->text('position');
            $form->text('sort');
            $form->text('title');
            $form->text('logo');
            $form->text('link');
            $form->text('enable');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
