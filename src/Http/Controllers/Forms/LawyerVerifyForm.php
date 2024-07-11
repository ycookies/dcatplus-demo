<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Validator;
use App\Models\XdLawyer;
use Illuminate\Support\Carbon;

class LawyerVerifyForm extends Form implements LazyRenderable {
    use LazyWidget; // 使用异步加载功能

    protected $payload = [];

    public function payload(array $payload) {
        $this->payload = array_merge($this->payload, $payload);

        return $this;
    }

    // 处理请求
    public function handle(array $input) {
        $request = Request();

        // Validate::make
        $validator = Validator::make($request->all(), [
            'id'         => 'required',
            'status'     => 'required|integer',
            'verify_msg' => 'required_if:status,2',
            //'descs'  => 'required',
        ], [
            'status.required'        => '审核状态 不能为空',
            'status.integer'         => '审核状态 只能是数字',
            'id.required'            => '序号ID 不能为空',
            'verify_msg.required_if' => '审核说明 不能为空',
        ]);

        if ($validator->fails()) {
            return $this->response()->error(implode(",", $validator->errors()->all()));
        }
        $verify_msg = $request->get('verify_msg', '');
        if($request->status == 2 && $verify_msg == ''){
            return $this->response()->error('请填写审核的拒绝理由');
        }

        $updata = [
            'audit_status'     => $request->get('status'),
            'refuse_msg' => $request->get('verify_msg', ''),
            'audit_time' => Carbon::now(),
        ];
        $lawyer_ids = explode(',', $input['id']);
        // 更新审核信息
        \App\Models\XdLawyer::whereIn('id', $lawyer_ids)->update($updata);

        // 自动统一设定咨询服务价格
        foreach ($lawyer_ids as $ids) {

        }

        // 自动统一设定咨询服务价格
        foreach ($lawyer_ids as $ids) {

        }


        // 发送通知
        return $this->response()->success('操作成功')->refresh();
    }

    public function form() {
        // 获取外部传递参数
        //$id = $this->payload['id'] ?? null;

        $this->select('status', '审核状态')
            ->options(XdLawyer::Status_arr)->required();
        // 密码确认表单
        $this->textarea('verify_msg', '审核说明');

        $this->hidden('id')->attribute('id', 'reset-password-id');
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
