<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Actions\Grid;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Models\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Widgets\Form as WidgetForm;
use App\Models\XdLawyer;
use Dcat\Admin\Form;
use App\Admin\Forms\LawyerVerifyRowForm;

class LawyerRowVerify extends RowAction
{
    /**
     * @return string
     */
	protected $title = '认证审核';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function render()
    {
        // 实例化表单类并传递自定义参数
        /*$id = $this->getKey();
        $form           = Form::make(new XdLawyer())->edit($id);
        $form->disableDeleteButton();
        $form->disableListButton();
        $form->disableViewButton();
        $form->disableResetButton();
        $form->disableViewButton();
        $form->disableEditingCheck();
        $form->disableHeader();
        $form->hidden('lawyer_id')->value($id);
        $form->select('status', '审核状态')
            ->when(1, function (Form $form) {
                $form->select('lawyer_level','律师评定等级')->options(XdLawyer::Lawyer_level_arr);
            })
            ->options(XdLawyer::Status_arr)
            ->required();
        $form->textarea('verify_msg', '审核说明');
        $form->action('/lawyerRowVerify');
        $form->confirm('确认保存吗？');
        $form->saved(function (Form $form, $result) {
            $form->response()->success('操作成功')->refresh();
        });*/

        // 实例化表单类
        $form = LawyerVerifyRowForm::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            //->onLoad($this->getModalScript()) // 弹窗显示后往隐藏表单写入选中的ID
            ->button('<button class="btn btn-primary">认证审核</button>');

        /*return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button('<button class="btn btn-primary">认证审核</button>');*/
    }

    public function handle(Request $request)
    {
        // dump($this->key());

        return $this->response()
            ->success('Processed successfully: '.$this->key())
            ->redirect('/');
    }

    /**
     * @return string|void
     */
    public function confirm()
    {
       //return 'Confirm?';
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
