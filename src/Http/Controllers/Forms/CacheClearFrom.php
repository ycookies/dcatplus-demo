<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Artisan;
class CacheClearFrom extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        //Artisan::call('debugbar:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return $this
				->response()
				->success('清除成功')
				->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        //$this->text('name')->required();
        //$this->email('email')->rules('email');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name'  => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}
