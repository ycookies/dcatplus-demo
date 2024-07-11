<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use App\Models\LawyerLevel;
use App\Models\XdLawyer;
use App\Models\XdService;
use App\Models\XdServiceInclude;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Carbon;
use Validator;
use App\Exceptions\SysErrorException;
use App\libary\wxkefu\Make as kfmake;

class LawyerVerifyRowForm extends Form implements LazyRenderable {
    use LazyWidget; // 使用异步加载功能

    protected $payload = [];

    public function payload(array $payload) {
        $this->payload = array_merge($this->payload, $payload);

        return $this;
    }

    // 处理请求
    public function handle(array $input) {
        $request = Request();
        $id      = $this->payload['id'] ?? null;
        // Validate::make
        $validator = Validator::make($request->all(), [
            'lawyer_id'    => 'required',
            'status'       => 'required|integer',
            'verify_msg'   => 'required_if:status,0',
            'lawyer_level' => 'required_if:status,1',
            'qywx_contact' => 'required_if:status,1',
        ], [
            'status.required'          => '审核状态 不能为空',
            'status.integer'           => '审核状态 只能是数字',
            'lawyer_id.required'       => '序号ID 不能为空',
            'verify_msg.required_if'   => '审核说明 不能为空',
            'lawyer_level.required_if' => '请选择律师评定的等级',
            'qywx_contact.required_if' => '请选择企业微信接待人员',
        ]);

        if ($validator->fails()) {
            return $this->response()->error(implode(",", $validator->errors()->all()));
        }
        $verify_msg = $request->get('verify_msg', '');
        if ($request->status == 2 && $verify_msg == '') {
            return $this->response()->error('请填写审核的拒绝理由');
        }

        $lawyer_id    = $request->get('lawyer_id');
        $status       = $request->get('status');
        $lawyer_level = $request->get('lawyer_level');
        $qywx_contact = $request->get('qywx_contact');
        if ($status == 2 && $lawyer_level == 0) {
            return $this->response()->error('请选择一个评定等级');
        }
        $info   = XdLawyer::find($lawyer_id);
        $updata = [
            'audit_status' => $status,
            'refuse_msg'   => $request->get('verify_msg', ''),
            'audit_time'   => Carbon::now(),
        ];
        if ($status == 1) {
            $updata['lawyer_level'] = $lawyer_level;
        }
        \DB::beginTransaction();
        try {
            // 更新审核信息
            XdLawyer::where('id', $lawyer_id)->update($updata);
            // 获取等级设定的价格
            $level_info  = LawyerLevel::where(['level_num' => $lawyer_level])->first();
            $zixun_price = $level_info->zixun_price;

            // 自动统一设定咨询服务价格
            $service = XdService::where(['seller_id' => $info->seller_id])->first();
            // 如果没有设定过
            if (empty($service->id)) {
                $includes_list_json = '[{"type":"call","type_name":"电话咨询","price":"'.$zixun_price.'","unit":"次"},{"type":"tuwen","type_name":"图文咨询","price":"'.$zixun_price.'","unit":"次"}]';
                $insdata    = [
                    'seller_id'     => $info->seller_id,
                    'title'         => $info->lawyer_name,
                    'service_img'   => $info->service_img,
                    'contents'      => $info->service_contents,
                    'category'      => 0,
                    'audit_status'  => 1,
                    'service_type'  => $info->getOriginal('industry'),//$info->industry,
                    'total_price'   => $zixun_price * 2,
                    'is_all_region' => 1,
                    'includes_list'=> $includes_list_json,
                    //'is_show'      => 1,
                ];
                $service_id = \DB::table('xd_service')->insertGetId($insdata);//XdService::create($insdata);
                if ($service_id) {
                    foreach (XdService::TypeArr as $key => $name) {
                        $skudata = [
                            'service_id' => $service_id,
                            'seller_id'  => $info->seller_id,
                            'title'      => $name,
                            'type'       => $key,
                            'contents'   => '',
                            'price'      => $zixun_price,
                            'unit'       => '次',
                        ];
                        $where   = ['service_id' => $service_id, 'type' => $key];
                        XdServiceInclude::firstOrCreate($where, $skudata);

                        /*$couts   = XdServiceInclude::where($where)->count();
                        if (empty($couts)) {
                            XdServiceInclude::model()->insert($skudata);
                        } else {
                            XdServiceInclude::model()->updateAll($where, $skudata);
                        }*/
                    }
                }
            }

            $kfinfos = \App\Models\LawyerKfInfo::where(['lawyer_id'=> $info->id])->first();
            if(!$kfinfos){
                // 生成客服账号 指定此人为接待人员
                $corpId = env('CorpId');;
                $kfconfig = \App\Models\LawyerKfConfig::where(['corpId'=> $corpId,'app_as'=>'wxkf'])->first();
                $kf_makes        = new  kfmake();
                $kf_makes->setCorpId($kfconfig->corpId);
                $kf_makes->setSecret($kfconfig->secret);

                $toux_img        = $kf_makes->download($info->image, public_path('lawyer/'));
                $lawyer_name     = str_replace('律师', '', $info->lawyer_name) . '律师';
                $res             = $kf_makes->addAccount($toux_img, $lawyer_name, $qywx_contact);
                if (!empty($res['open_kfid'])) {
                    $form = new \App\Models\LawyerKfInfo();
                    $form->corpId = $corpId;
                    $form->lawyer_id = $info->id;
                    $form->seller_id = $info->seller_id;
                    $form->kf_name          = $lawyer_name;
                    $form->kf_toux_media_id = $res['media_id'];
                    $form->open_kfid     = $res['open_kfid'];
                    $form->kf_link          = $res['kf_link'];
                    $form->jiedaiyuan_list  = implode(',', $res['jiedaiyuan_list']);
                    $form->index_jiedaiyuan = $res['jiedaiyuan_list'][0];
                    $form->save();
                }
            }


            \DB::commit();
            // 发送通知
            return $this->response()->success('操作成功')->refresh();
        } catch (\Error $error) {
            \DB::rollBack();
            throw new SysErrorException($error);
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw new SysErrorException($exception);
        }

        return $this->response()->error('系统繁忙,请稍后重试');
    }

    public function form() {

        // 获取外部传递参数
        $id = $this->payload['id'] ?? null;
        $this->hidden('lawyer_id')->value($id);
        $this->select('status', '选择审核状态')
            ->when(1, function (Form $form) {
                $corpId = env('CorpId');
                $config      = \App\Models\LawyerKfConfig::where(['corpId' => $corpId, 'app_as' => 'wxkf'])->first()->toArray();
                $app_makes        = new  kfmake();
                $app_makes->setCorpId($corpId);
                $app_makes->setSecret($config['secret']);
                $res = $app_makes->getContactLists();

                $contacts = [];
                foreach ($res['list'] as $items){
                    $contacts[$items['userid']] =  $items['name']."(".$items['userid'].")";
                }
                $form->select('lawyer_level', '律师评定等级')->help('评定的等级直接跟服务售卖价格关联')->options(XdLawyer::Lawyer_level_arr)->required();
                $form->select('qywx_contact','企业微信人员')->options($contacts)->help('选用此人来做咨询接待')->required();
            })
            ->options(XdLawyer::Status_arr)->required();
        // 密码确认表单
        $this->textarea('verify_msg', '审核说明');

        //$this->hidden('id')->attribute('id', 'reset-password-id');
    }

    // 返回表单数据，如不需要可以删除此方法
    /*public function default()
    {
        return [
            'password'         => '',
            'password_confirm' => '',
        ];
    }*/
}
