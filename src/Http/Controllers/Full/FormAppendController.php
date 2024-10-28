<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use App\Http\Controllers\Controller;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Faker\Factory;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Dcat\Admin\Models\Setting as SettingModel;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Calendar;
use Dcat\Admin\Widgets\Card;
class FormAppendController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        if (request()->getMethod() == 'POST') {
            $content->row(Box::make('POST', $this->dump(request()->all()))->style('default'));
        }

        $content->row('<div style="margin:5px 0 15px;">'.$this->buildPreviewButton().'</div>');

        $content->row(function (Row $row) {
            $type = request('_t', 1);

            $tab = new Tab();

            // if ($type == 1) {
            //     $tab->add('Form-1', $this->form1());
            //     $tab->addLink('Form-2', request()->fullUrlWithQuery(['_t' => 2]));
            // } else {
            //     $tab->addLink('Form-1', request()->fullUrlWithQuery(['_t' => 1]));
            //     $tab->add('Form-2', $this->form2(), true);
            // }
            $tab->add('Form-1', $this->form1(),false,'Form-1');

            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('Form');
    }

    protected function form1()
    {
        $events_list = [
            [
                'title' => '今天的事项',
                'start' => '2024-10-01 14:00:00', // 示例日期，您可以根据需要替换
                'backgroundColor' => '#f56954', // red
                'borderColor' => '#f56954', // red
                'allDay' => false, // 指示事件是否为全天事件。默认为 false
                'description' => '这是今天的事项描述', // 描述信息
                'showModal' => true,
            ],
            [
                'title' => '长事项',
                'start' => '2024-10-27T00:00:00', // 示例日期，您可以根据需要替换
                'end' => '2024-10-30T00:00:00', // 示例日期，您可以根据需要替换
                'backgroundColor' => '#f39c12', // yellow
                'borderColor' => '#f39c12', // yellow
                'showModal' => true,
            ],
            [
                'title' => 'Meeting 11111',
                'start' => '2024-10-02T10:30:00', // 示例日期，您可以根据需要替换
                'allDay' => false,
                'backgroundColor' => '#0073b7', // Blue
                'borderColor' => '#0073b7', // Blue
            ],
            [
                'title' => 'Lunch 2222',
                'start' => '2024-10-02T12:00:00', // 示例日期，您可以根据需要替换
                'end' => '2024-10-02T14:00:00', // 示例日期，您可以根据需要替换
                'allDay' => false,
                'backgroundColor' => '#00c0ef', // Info (aqua)
                'borderColor' => '#00c0ef', // Info (aqua)
            ],
            [
                'title' => 'Birthday Party',
                'start' => '2024-10-03T19:00:00', // 示例日期，您可以根据需要替换
                'end' => '2024-03T22:30:00', // 示例日期，您可以根据需要替换
                'allDay' => false,
                'backgroundColor' => '#00a65a', // Success (green)
                'borderColor' => '#00a65a', // Success (green)
            ],
            [
                'title' => 'Click for baidu',
                'start' => '2024-10-28T00:00:00', // 示例日期，您可以根据需要替换
                'end' => '2024-10-29T00:00:00', // 示例日期，您可以根据需要替换
                'url' => 'https://www.baidu.com/',
                'backgroundColor' => '#3c8dbc', // Primary (light-blue)
                'borderColor' => '#3c8dbc', // Primary (light-blue)
            ],
        ];


        $calendar = \Dcat\Admin\Widgets\Calendar::make();
        $calendar->eventItem($events_list);

        $Card = Card::make($calendar->render());
        $form = Form::make(new SettingModel());
        $form->html($Card->render())->width(8);

        /*$alendar1 = Calendar::make();
        $alendar1->initialView('listWeek');
        $Card1 = Card::make($alendar1->render());
        $form->html($Card1->render())->width(10);*/

        $form->action(request()->fullUrl());
        $startDate = '2021-09-08';$endDate = '2021-12-08';

        $form->iconimg('rights_icon','图标')
            ->nametype('datetime')
            ->remove(true)
            ->help('图标，可删除,文件重命名方式:datetime');

        $form->photo('photo1','图片1')
            ->nametype('datetime')
            ->remove(true)
            ->help('单图，可删除,文件重命名方式:datetime');

        $form->photo('photo2','图片2')
            //->path('pic')
            ->nametype('uniqid')
            ->remove(true)
            ->help('单图，不可删除');

        $form->photo('photo3','图片3')
            ->nametype('uniqid')
            ->help('单图，不可删除.文件重命名方式:uniqid');

        $form->photos('photo4', '图片4')
            ->path('pic')
            ->pageSize(16)
            ->nametype('uniqid')
            ->limit(9)
            ->remove(true)
            ->help('多图 数据库结构 json');;  //可删除

        $form->video('video1','视频1')
            ->path('video')
            ->nametype('uniqid')
            ->remove(true)
            ->help('视频 数据库结构 json/varchar');  //可删除*/

        $form->multiDate('mul','多个日期');
        $skuParams = [
            // 扩展第一列
            [
                'name'    => '会员价', // table 第一行 title
                'field'   => 'member_price', // input 的 field_name 名称
                'default' => 5, // 默认值
            ],
            // 扩展第二列
        ];
        $form->sku('sku','商品SKU')->addColumn($skuParams);
        //$form->date('dates','dates');
        $form->distpicker(['province_id', 'city_id', 'district_id'], '经营场所在地')->required();
        $form->image('touxiang', '头像-指定示例图')
            ->help('<a href="https://gtimg.wechatpay.cn/resource/xres/img/202308/1344340ea9fde9b9b4882c817d54282e_304x192.png" target="_blank"><b>【查看示例】</b></a> 1.请上传彩色照片 or 彩色扫描件 or 加盖公章鲜章的复印件，要求正面拍摄，露出证件四角且清晰、完整，所有字符清晰可识别，不得反光或遮挡。不得翻拍、截图、镜像、PS。
2.图片只支持JPG、BMP、PNG格式，文件大小不能超过2M。')
            ->exampleImg('https://gtimg.wechatpay.cn/resource/xres/img/202308/d5f2c28fb232b240cfb190dfc4469227_1080x771.png');

        $form->diyForm('field_name','自定义表单')->themeColor('red');
        return "<div style='padding:10px 8px'>{$form->render()}</div>";
    }


    /**
     * 生成随机数据
     *
     * @return array
     */
    protected function createNames()
    {
        if (isset($this->names)) {
            return $this->names;
        }
        $faker = Factory::create();
        $this->names = [];

        for ($i = 0; $i < 15; $i ++) {
            $name = $faker->name;
            $this->names[$name] = $name;
        }

        return $this->names;
    }

    protected function dump($content)
    {
        VarDumper::setHandler(function ($data) {
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();
            $dumper->dump($cloner->cloneVar($data));
        });

        ob_start();
        VarDumper::dump($content);

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
