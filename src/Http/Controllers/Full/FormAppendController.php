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


        $form = Form::make(new SettingModel());

        $form->action(request()->fullUrl());

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
