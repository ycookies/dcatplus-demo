<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;


use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Form as WidgetForm;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Alert;
use App\Models\ChaogPartner;

class DemoCropperController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('图片剪裁')
            ->description('图片剪裁')
            ->body($this->forms());
    }

    protected function forms()
    {

        $htmll = <<<HTML
<ul>
    <li>作者： <a href="#" target="_blank"> weiwait</a>。 此人贡献了多个实用，好用的扩展，在此感谢他的辛勤付出</li>
</ul>
HTML;

        $alert = Alert::make($htmll, '提示:');


        $form =  Form::make(new ChaogPartner(), function (Form $form) {
            $form->display('id');
            $form->cropper('column', '图片剪裁')
                //->jpeg(0.5) // 0 ~ 1
                ->useBase64() // 采用base64编码图片统一提交
                //->ratio(16/9) // 快捷裁剪选项配置（裁剪比率）
                //->resolution(1920, 1080)
                ->ratio(1)
                //->resolution(100) // 等比
                //->ratio(['1:1' => 1, '16:9' => 16/9, '自定义' => null]) // 多预设
                //->resolution(['1:1' => [300, 300], '16:9' => [1920, 1080]])
                ->options([
                    // https://github.com/fengyuanchen/cropperjs
                    // 裁剪选项
                    'cropper' => [
                        'aspectRatio' => 16/9,
                        'background' => false,
                    ]
                ]);
        });

        /*$form = Form::make(new ChaogPartner());
        $form->text('position');*/
        $Card = Card::make('基本项', $form);

        //return $Card;
        return $alert->success().$Card;

    }
}
