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
use App\Models\LawyerKfConfig;
use App\libary\wxkefu\Make as kfmake;

class GetCorpJoinQrcode extends RowAction
{
    /**
     * @return string
     */
	protected $title = '获取加入企业二维码';

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
        $id = $this->getKey();
        $info = LawyerKfConfig::find($id);
        /*$contactinfo =  LawyerKfConfig::where(['corpId'=> $info->corpId,'app_as'=>'contact'])->first();

        $kfmake = new kfmake();
        $kfmake->setCorpId($info->corpId);
        $kfmake->setSecret($contactinfo->secret);
        $res = $kfmake->sendApi('/corp/get_join_qrcode',[],false)->getResult();
        //info('get_join_qrcode',$res);
        if(isset($res['errcode']) && $res['errcode'] == 0){
            $info->join_qrcode = $res['join_qrcode'];
            $info->save();
        }*/
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body("<img src='$info->join_qrcode' width='160'/>")
            ->button('<button class="btn btn-primary">企业二维码</button>');
    }

    public function handle(Request $request)
    {
        // dump($this->key());

        return $this->response()
            ->success('Processed successfully: ');
            //->redirect('/');
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
