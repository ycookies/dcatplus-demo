<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Callout;
use Illuminate\Support\Str;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form as WidgetsForm;

class DataVController extends Controller
{

    public function index(Content $content)
    {

        return $content->header('数据看板')
            ->description('数据看板')
            ->body($this->pageMain());
    }

    public function pageMain(){
        $req = Request()->all();
        $type = request('_t', 1);
        $tab = Tab::make();
        // 第一个参数是选项卡标题，第二个参数是内容，第三个参数是是否选中
        $tab->add('智能看板新中心',$this->tab0());
        //$tab->add('通知',$this->tab1());
        //$tab->add('密码修改', $this->tab2());
        //$tab->add('子帐号',$this->tab3());
        // 添加选项卡链接
        //$tab->addLink('跳转链接', 'http://xxx');
        return $tab->withCard();
    }
    // 订房相关
    public function tab0(){
        $id = Request()->get('id','069');
        $card =  Card::make('',view('admin.datav.demo1',compact('id')));
        return $card;
    }


    public function demo1(Content $content)
    {
        $data = [
            'appid' => 'wx7246aea8d02dabdf',
            'bank_type' => 'OTHERS',
            'cash_fee' => '300',
            'fee_type' => 'CNY',
            'is_subscribe' => 'N',
            'mch_id' => '1566291601',
            'nonce_str' => '65f7e6d9a0fe4',
            'openid' => 'oADNc5IBIYUVZUUv-fIQWmo_6COE',
            'out_trade_no' => 'RBW2024031815014572',
            'result_code' => 'SUCCESS',
            'return_code' => 'SUCCESS',
            'sign' => 'C74DA2696F4D5E786E5CC6A481EB2EC9',
            'sub_mch_id' => '1644702947',
            'time_end' => '20240318150207',
            'total_fee' => '300',
            'trade_type' => 'JSAPI',
            'transaction_id' => '4200002165202403188099714362',
            'hexiao_code' => '42414710', // 核对到店
            'remarks' => '小程序订房:仿宋街景阳台双床房(1天 [2024-3-19 -> 2024-3-20] ),预订人：杨光，联系电话:17681849188', // 订房信息
        ];
    }
}
