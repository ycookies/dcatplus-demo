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

class FormController extends Controller
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
            $tab->add('Form-2', $this->form2(),false,'Form-2');
            $tab->add('Form-3', $this->form3(),false,'Form-3');
            //$tab->add('SKU表单', $this->form4(),false,'Form-4');
            $tab->title('<h1 class="text-warning">这是一个表单示例大全</h1>');
            $options = ['去百度','https://www.baidu.com'];
            $tab->dropdown($options,'下拉菜单');
            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('Form');
    }
    public function kkk($path){
        $sourcePath = public_path('uploads') .'/'. $path;
        if (file_exists($sourcePath)){
            // 缩略图
            $thumbnailFile = self::$thumbnailPath.'/'.self::getThumbnailName($path, self::$thumbnailSize);
            $thumbnailPath = public_path('uploads').'/'.$thumbnailFile;
            if (!file_exists($thumbnailPath))
            {
                $thumbnailDir = public_path('uploads').'/'.self::$thumbnailPath;
                if(!is_readable($thumbnailDir))
                    mkdir($thumbnailDir,0700);

                $img = Image::make($sourcePath);
                $img->fit(self::$thumbnailSize);
                $img->save($thumbnailPath);
            }
            return Storage::url($thumbnailFile);
        }
    }
    protected function form1()
    {


        $form = Form::make(new SettingModel());

        $form->action(request()->fullUrl());

        $form->text('form1.text', 'text')->required();
        $form->password('form1.password', 'password')->required();
        $form->email('form1.email', 'email');
        $form->mobile('form1.mobile', 'mobile');
        $form->url('form1.url', 'url');
        $form->ip('form1.ip', 'ip');

        $form->color('form1.color', 'color');
        //$form->distpicker(['province_id', 'city_id', 'district_id'], '经营场所在地')->required();
        /*$form->tab('Profile', function (Form $form) {

            $form->image('avatar');
            $form->text('address');
            $form->mobile('phone');

        });*/


        $form->divider();
        $form->selectTable('form1.select-table', 'Select Table')
            ->title('User')
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name');

        $form->multipleSelectTable('form1.select-resource-multiple', 'Multiple Select Table')
            ->title('User')
            ->max(4)
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name');

        $form->icon('form1.icon', 'icon');
        $form->rate('form1.rate', 'rate')->addElementClass(['rate01', 'rateok'], false);
        $form->decimal('form1.decimal', 'decimal');
        $form->number('form1.number', 'number');
        $form->currency('form1.currency', 'currency');
        $form->switch('form1.switch', 'switch')->default(1);

        $form->divider();

        $form->date('form1.date', 'date');
        $form->time('form1.time', 'time');
        $form->datetime('form1.datetime', 'datetime');
        $form->dateRange('form1.date-start', 'form1.date-end', 'date range');
        $form->timeRange('form1.time-start', 'form1.time-end', 'time range');
        $form->datetimeRange('form1.datetime-start', 'form1.datetime-end', 'datetime range');
        $form->tags('keywords');
        /*$form->iconimg('rights_icon','图标')
            ->nametype('datetime')
            ->remove(true)
            ->help('图标，可删除,文件重命名方式:datetime');

        $form->photo('photo1','图片1')
            ->nametype('datetime')
            ->remove(true)
            ->help('单图，可删除,文件重命名方式:datetime');

        $form->photo('photo2','图片2')
            ->path('pic')
            ->nametype('uniqid')
            ->remove(false)
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
            ->help('视频 数据库结构 json/varchar');*/  //可删除

        /*$form->mediaSelector('files', '系列文件')
            ->options(['length' => 10])
            ->help('上传或选择10个文件，不限类型');

        $form->mediaSelector('images', '系列图片')
            ->options(['length' => 10,'type' => 'image'])
            ->help('上传或选择10个图片');

        $form->mediaSelector('file', '文件压缩包')
            ->options(['type' => 'zip'])
            ->help('上传或选择一个文件压缩包');*/

        $form->html(function () {
            return '<b>自定义HTML</b>';
        }, 'html')->help('自定义内容');

        $form->textarea('form1.textarea', 'textarea');

        $form->divider();
        $form->radio('mode', '登陆方式')
            ->options([
                1 => '账号登陆',
                2 => 'token登陆'
            ])
            ->when([1], function (Form $form) {
                $form->text('discord.account')->rules(['require', '请输入账户']);
                $form->text('discord.password')->rules(['require', '请输入密码']);
            })
            ->when([2], function (Form $form) {
                $form->text('discord.token')->rules(['require', '请输入token']);
            })
            ->default(2);

        $form->table('table', function (NestedForm $table) {
            $table->text('key');
            $table->text('value');
            $table->text('desc');
        });

        return "<div style='padding:10px 8px'>{$form->render()}</div>";
    }

    protected function form2()
    {
        $form = new Form();

        $form->action(request()->fullUrl());

        $names = $this->createNames();

        $form->tags('form2.tag', 'Tag')->options($names);
        $form->select('form2.select', 'select')->options($names);
        $form->multipleSelect('form2.multiple-select', 'multiple select')->options($names);
        $form->image('form2.image', 'image');
        $form->multipleFile('form2.multiple-file', 'multiple file')->limit(3);
        $form->checkbox('form2.checkbox', 'checkbox')->options(['GET', 'POST', 'PUT', 'DELETE'])->canCheckAll()->default(1);
        $form->radio('form2.radio', 'radio')->options(['GET', 'POST', 'PUT', 'DELETE'])->default(0);

        /*$menuModel = config('admin.database.menu_model');
        $menuModel = new $menuModel;
        $form->tree('form2.tree', 'tree')
            ->setTitleColumn('title')
            ->nodes($menuModel->allNodes());*/

        $form->listbox('form2.listbox', 'listbox')->options($names);

        $form->editor('form2.editor', 'editor');
        $form->markdown('form2.markdown', 'markdown');

        return "<div style='padding:9px 8px'>{$form->render()}</div>";
    }

    protected function form3(){
        $form = Form::make(new SettingModel());
        $form->action(request()->fullUrl());
        $form->keyValue('keyValue1','键值对象')->default(['cny' => '', 'usd' => ''])->setKeyLabel('键名')->setValueLabel('键值');
        $form->embeds('embeds','固定键值对象', function ($form) {
            $form->text('key1')->required();
            $form->email('key2')->required();
            $form->datetime('key3');
        
            $form->dateRange('key4', 'key5', '范围')->rules('required');
        });

        $form->list('list_name','一维数组')->max(10)->min(5);
        $form->array('column_name','二维数组',function ($table) {
            $table->text('key');
            $table->text('value');
            $table->textarea('desc');
        })->saveAsJson();

        $form->divider();
        $form->table('column_name','表格形式', function ($table) {
            $table->text('key')->prepend('');
            $table->text('value')->prepend('');
            $table->text('desc');
        });
        $form->table('column_name2','表格形式-select', function ($table) {
            $table->text('key')->prepend('');
            $table->select('value')->options(['1'=>'第一项','2'=>'第二项']);
            $table->text('desc');
        });
        $form->table('column_name2','表格形式-icon', function ($table) {
            $table->text('title')->prepend('');
            $table->text('desc');
            $table->iconimg('icon')->nametype('datetime')
            ->remove(true);
        });
        return "<div style='padding:10px 8px'>{$form->render()}</div>";
    }

    public function form4(){

        $form = Form::make(new SettingModel());
        $form->action(request()->fullUrl());
        $form->setFormId('form-4');
        $skuParams = [];
        $form->sku('sku', '生成SKU')->addColumn($skuParams);
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
