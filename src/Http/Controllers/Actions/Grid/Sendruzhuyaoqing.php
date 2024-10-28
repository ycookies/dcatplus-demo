<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Actions\Grid;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Models\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\LawyerKfConfig;
use App\libary\wxkefu\Make as kfmake;

class Sendruzhuyaoqing extends RowAction
{
    //protected $userid;


    /**
     * @return string
     */
	protected $title = '<i class="fa fa-paper-plane"></i>发送入驻邀请';


    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $userid = $request->get('userid');
        $corpid = env('CorpId');
        $config      = LawyerKfConfig::where(['corpId' => $corpid, 'app_as' => 'minapp_lawyer'])->first();
        //$touser      = requests('touser', 'DiaoSaiTong');
        $msg_content = [
            "touser"                   => $userid,
            "toparty"                  => "1",
            "totag"                    => "1",
            "msgtype"                  => "news",
            "agentid"                  => $config['agentid'], //应用ID
            "news"                     => [
                "articles" => [
                    [
                        "title"       => "律鸟法律咨询平台邀请您入驻",
                        "description" => "获取更多优质客户",
                        "url"         => "URL",
                        "picurl"      => "https://lvapi.luanfengip.com/img/reg-banner.jpg",
                        "appid"       => "wxef576cd8ad4cc3c0",
                        "pagepath"    => "pages/login/index"
                    ]
                ]
            ],
            "enable_id_trans"          => 0,
            "enable_duplicate_check"   => 0,
            "duplicate_check_interval" => 1800
        ];

        $kfmake = new kfmake();
        $kfmake->setCorpId($config->corpId);
        $kfmake->setSecret($config->secret);
        $res    = $kfmake->sendApi('message/send', $msg_content, true)->getResult();
        if (isset($res['errcode']) && $res['errcode'] == 0){
            return $this->response()->success('发送成功');
        }else{
            return $this->response()->success('发送失败'.$res['errmsg']);
        }

    }

    /**
     * 设置确认弹窗信息，如果返回空值，则不会弹出弹窗
     *
     * 允许返回字符串或数组类型
     *
     * @return array|string|void
     */
    public function confirm()
    {
        return ["您确定现在发送吗?"];
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
     * 设置要POST到接口的数据
     *
     * @return array
     */
    public function parameters()
    {
        return [
            // 发送当前行 username 字段数据到接口
            'userid' => $this->row->userid,
            'corpid' => $this->row->corpid,
        ];
    }
}
