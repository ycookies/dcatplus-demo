<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use Illuminate\Http\Request;

/**
 * 表单字段全目录：扩展包全部表单字段 + 通用功能，一项一项示例.
 *
 * 三条访问方式均可用：资源 Form / Widgets\Form（本页）/ 弹窗表单
 * （Modal + LazyRenderable，见 ModalFormController）。
 */
class FormFieldsController extends Controller
{
    use \Dcat\Admin\DcatplusDemo\Http\Controllers\Full\PreviewCode;

    public function index(Content $content)
    {
        $content->row('<div style="margin:5px 0 15px;">'.$this->buildPreviewButton().'</div>');

        $content->row(function (Row $row) {
            $tab = new Tab();
            $tab->add('文本与基础', $this->groupText(), false, 'text');
            $tab->add('选择类', $this->groupSelect(), false, 'select');
            $tab->add('日期时间', $this->groupDate(), false, 'date');
            $tab->add('数字与滑块', $this->groupNumber(), false, 'number');
            $tab->add('文件与图片', $this->groupFile(), false, 'file');
            $tab->add('编辑器', $this->groupEditor(), false, 'editor');
            $tab->add('数组与关系', $this->groupRelation(), false, 'relation');
            $tab->add('布局与装饰', $this->groupLayout(), false, 'layout');
            $tab->title('<h1 class="text-warning">表单字段全目录（每项均可提交验证）</h1>');
            $row->column(12, $tab->withCard());
        });

        return $content->header('表单字段全目录')->description('覆盖扩展包全部表单字段与通用功能，一次一项');
    }

    protected function box(string $title, Form $form): string
    {
        return Box::make($title, $form)->render();
    }

    /* ================= 一、文本与基础 ================= */

    protected function groupText()
    {
        $forms = [];

        // 通用选项集中演示
        $f = new Form();
        $f->text('text_base', 'text 基础')
            ->required()                        // 必填（前端 + 后端）
            ->help('required 必填 + help 帮助说明 + 默认值')
            ->default('默认值示例');
        $f->text('text_rules', 'text 验证规则')
            ->rules('required|min:5', ['min' => '至少 5 个字符'])  // 后端规则 + 自定义消息
            ->attribute('placeholder', 'attribute 设置的 placeholder')
            ->pattern('[0-9]+')                 // 前端 pattern
            ->help('rules 后端验证 + attribute 原生属性 + pattern 正则');
        $f->text('text_readonly', 'text 只读')
            ->readonly()
            ->value('readonly 只读不可编辑');
        $f->text('text_disable', 'text 禁用')
            ->disable()
            ->value('disable 禁用（灰化）');
        $f->text('text_width', 'text 宽度')
            ->width(4, 8)                       // label/field 栅格宽度
            ->help('width(4, 8) 控制栅格占比');
        $f->text('text_prefix', 'text 前后缀')
            ->prepend('￥')
            ->append('元')
            ->help('prepend/append 输入框前后缀');
        $forms[] = $this->box('text —— 文本框 + 通用选项（required/help/rules/attribute/pattern/readonly/disable/width/prefix/suffix）', $f);

        $f = new Form();
        $f->email('email', 'email')->help('邮箱格式验证');
        $f->mobile('mobile', 'mobile')->help('手机号格式');
        $f->ip('ip', 'ip')->help('IP 地址格式');
        $f->tel('tel', 'tel')->help('电话号码');
        $f->url('url', 'url')->help('URL 格式');
        $f->password('password', 'password');
        $f->autocomplete('autocomplete', 'autocomplete')
            ->options(['dcat-admin', 'dcat-plus', 'laravel', 'php'])
            ->help('dcat-plus 新增：输入自动补全');
        $f->hidden('hidden_field', '')->default('hidden 隐藏域值');
        $f->display('display_field', 'display')->value('display 只读展示（纯文本）');
        $f->id('id_field', 'id')->value(42);
        $forms[] = $this->box('email / mobile / ip / tel / url / password / autocomplete / hidden / display / id', $f);

        $f = new Form();
        $f->text('captcha_note', 'captcha —— 图形验证码（说明）')
            ->value('需先安装 mews/captcha 包：composer require mews/captcha，然后 $form->captcha()')
            ->readonly();
        $forms[] = $this->box('captcha —— 图形验证码（依赖 mews/captcha）', $f);

        return implode('', $forms);
    }

    /* ================= 二、选择类 ================= */

    protected function groupSelect()
    {
        $genders = [0 => '保密', 1 => '男', 2 => '女'];
        $cities = [1 => '北京', 2 => '上海', 3 => '广州', 4 => '深圳'];

        $f = new Form();
        $f->select('select_single', 'select 单选')->options($cities)->required();
        $f->select('select_search', 'select 可搜索')
            ->options($cities)
            ->help('select2 可搜索下拉');
        $f->select('select_config', 'select 自定义配置')
            ->options($cities)
            ->config('allowClear', false)
            ->help('config() 透传 select2 配置');
        $forms[] = $this->box('select —— 单选下拉（options/config/搜索）', $f);

        $f = new Form();
        $f->multipleSelect('multi_select', 'multipleSelect')->options($cities);
        $f->radio('radio_field', 'radio')->options($genders)->default(0);
        $f->checkbox('checkbox_field', 'checkbox')->options(['PHP', 'Laravel', 'JS'])->saving(function ($v) {
            return implode(',', (array) $v);
        });
        $f->switch('switch_field', 'switch')->default(1);
        $forms[] = $this->box('multipleSelect / radio / checkbox / switch', $f);

        $f = new Form();
        $f->listbox('listbox_field', 'listbox')->options($cities);
        $f->tags('tags_field', 'tags')->help('标签输入，逗号分隔多个');
        $f->tree('tree_field', 'tree')->nodes([
            ['id' => '1', 'text' => '根节点', 'children' => [
                ['id' => '2', 'text' => '子节点 A'],
                ['id' => '3', 'text' => '子节点 B', 'children' => [
                    ['id' => '4', 'text' => '孙节点'],
                ]],
            ]],
        ])->expand(true);
        $forms[] = $this->box('listbox / tags / tree（树形选择）', $f);

        // select 联动 load
        $f = new Form();
        $f->select('load_province', 'select load 联动（省）')->options($cities)
            ->help('load(city, api)：选择省后异步加载市——接口返回 [{id,text}]');
        $f->select('load_city', 'select load 联动（市）')->options([]);
        $f->select('load_province_2', 'load 反向刷新')->options($cities)->loads(['load_city_2' => '']);
        $f->select('load_city_2', '联动目标')->options([]);
        $forms[] = $this->box('select load()/loads() —— 下拉联动加载', $f);

        return implode('', $forms);
    }

    /* ================= 三、日期时间 ================= */

    protected function groupDate()
    {
        $f = new Form();
        $f->date('date_field', 'date')->help('日期选择')->default(date('Y-m-d'));
        $f->month('month_field', 'month')->help('月份选择');
        $f->datetime('datetime_field', 'datetime')->help('日期时间');
        $f->time('time_field', 'time')->help('时间选择');
        $f->year('year_field', 'year')->help('年份选择');
        $forms[] = $this->box('date / month / datetime / time / year', $f);

        $f = new Form();
        $f->dateRange('date_range', 'dateRange')->help('日期区间');
        $f->datetimeRange('datetime_range', 'datetimeRange')->help('日期时间区间');
        $f->timeRange('time_range', 'timeRange')->help('时间区间');
        $f->multiDate('multi_date', 'multiDate')->help('多日期选择（可叠加多个日期）');
        $forms[] = $this->box('dateRange / datetimeRange / timeRange / multiDate', $f);

        return implode('', $forms);
    }

    /* ================= 四、数字与滑块 ================= */

    protected function groupNumber()
    {
        $f = new Form();
        $f->number('number_field', 'number')->min(1)->max(100)->default(10)->help('min/max 步进数字');
        $f->currency('currency_field', 'currency')->symbol('¥')->default(99.00)->help('货币（symbol 符号）');
        $f->decimal('decimal_field', 'decimal')->default(3.1415)->help('小数');
        $f->rate('rate_field', 'rate')->default(50)->help('百分比评分（prepend %）');
        $forms[] = $this->box('number / currency / decimal / rate', $f);

        $f = new Form();
        $f->slider('slider_field', 'slider')->options(['type' => 'double', 'from' => 20, 'to' => 80, 'min' => 1, 'max' => 100])
            ->help('options 透传 ionRangeSlider 配置');
        $f->range('range_field', 'range')->help('区间数字输入');
        $forms[] = $this->box('slider / range', $f);

        return implode('', $forms);
    }

    /* ================= 五、文件与图片 ================= */

    protected function groupFile()
    {
        $f = new Form();
        $f->image('image_field', 'image')->autoUpload()->uniqueName()->help('单图（autoUpload 自动上传）');
        $f->multipleImage('images_field', 'multipleImage')->limit(4)->help('多图（limit 上限）');
        $f->file('file_field', 'file')->help('单文件');
        $f->multipleFile('files_field', 'multipleFile')->help('多文件');
        $forms[] = $this->box('image / multipleImage / file / multipleFile（WebUploader）', $f);

        return implode('', $forms);
    }

    /* ================= 六、编辑器 ================= */

    protected function groupEditor()
    {
        $f = new Form();
        $f->editor('editor_field', 'editor')->height(200)->help('富文本编辑器');
        $f->wangEditor('wangeditor_field', 'wangEditor')->height(200)->help('wangEditor 编辑器');
        $f->markdown('markdown_field', 'markdown')->height(220)->help('Markdown（支持粘贴图片自动上传）');
        $forms[] = $this->box('editor / wangEditor / markdown（UEditor 见「表单示例大全」页）', $f);

        return implode('', $forms);
    }

    /* ================= 七、数组与关系 ================= */

    protected function groupRelation()
    {
        $f = new Form();
        $f->hasMany('members', 'hasMany（一对多表单）', function ($n) {
            $n->text('name', '姓名')->rules('required');
            $n->text('phone', '电话');
        });
        $f->table('contacts', 'table（表格表单）', function ($n) {
            $n->text('name', '姓名');
            $n->text('email', '邮箱');
        })->help('紧凑表格形态的一对多');
        $f->sku('sku_field', 'sku（SKU 规格）')->help('dcat-plus：SKU 规格组合字段');
        $forms[] = $this->box('hasMany / table / sku', $f);

        $f = new Form();
        // array 的第二参是 builder 闭包而非 label
        $f->array('array_field', function ($n) {
            $n->text('key', '键');
            $n->text('value', '值');
        })->help('array：动态行编辑');
        $f->keyValue('kv_field', 'keyValue')->default(['color' => 'red', 'size' => 'XL'])->help('固定键值对编辑');
        $f->list('list_field', 'list')->default(['苹果', '香蕉'])->help('简单列表');
        $f->draggableList('drag_field', 'draggableList')->default([
            ['id' => '1', 'title' => '第一项', 'icon' => 'feather icon-home', 'path' => '/home'],
            ['id' => '2', 'title' => '第二项', 'icon' => 'feather icon-settings', 'path' => '/settings'],
        ])->help('可拖拽排序列表（项含 id/title/icon/path 结构）');
        $forms[] = $this->box('array / keyValue / list / draggableList', $f);

        $f = new Form();
        $f->embeds('profile', 'embeds（嵌套字段组）', function ($n) {
            $n->text('site', '网站');
            $n->email('email', '邮箱');
        });
        $f->selectTable('select_table', 'selectTable（弹窗选表格）')
            ->title('选择用户')
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name')
            ->help('dcat-plus：弹窗表格选择器（from 指定 LazyRenderable 数据源）');
        $f->multipleSelectTable('multi_select_table', 'multipleSelectTable')
            ->title('选择多个用户')
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name')
            ->help('dcat-plus：多选弹窗表格');
        $forms[] = $this->box('embeds / selectTable / multipleSelectTable（dcat-plus）', $f);

        $f = new Form();
        $f->map('map_field', 'map（地图坐标）')->help('需配置腾讯/百度地图 key（config admin.map）');
        $f->distpicker(['province', 'city', 'district'], 'distpicker（省市区）')->help('省市区三级联动（column 为数组）');
        $f->timezone('timezone_field', 'timezone')->help('时区选择');
        $f->color('color_field', 'color')->default('#586cb1')->help('颜色选择器');
        $f->icon('icon_field', 'icon')->default('feather icon-box')->help('图标选择器');
        $forms[] = $this->box('map / distpicker / timezone / color / icon', $f);

        return implode('', $forms);
    }

    /* ================= 八、布局与装饰 ================= */

    protected function groupLayout()
    {
        $f = new Form();
        $f->html('<div style="padding:8px;background:#f4f6fb;border-radius:4px">html 字段：插入任意 HTML/说明块</div>');
        $f->html('<hr style="margin:12px 0;border-color:#ddd">');
        $f->text('after_divide', '分割线之后的字段');
        $f->fieldset('fieldset 分组框', function (Form $n) {
            $n->text('fs_name', '组内字段 A');
            $n->text('fs_code', '组内字段 B');
        });
        $f->button('button 自定义按钮');
        $forms[] = $this->box('html / fieldset / button（divide 仅资源 Form 有，此处用 html 分隔线）', $f);

        return implode('', $forms);
    }
}
