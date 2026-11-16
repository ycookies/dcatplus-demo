<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewDevices;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\NewUsers;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Metrics\Examples\TotalUsers;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\PostTable;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable\UserTable;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Faker\Factory;
use Illuminate\Routing\Controller;

class GridController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('表格')
            ->description('表格功能展示')
            //->body('表格功能展示');
            ->body(function (Row $row) {
                $row->column(4, new TotalUsers());
                $row->column(4, new NewUsers());
                $row->column(4, new NewDevices());
            })
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {
            $grid->number();
            //$grid->enableDialogCreate();

            // 设置弹窗宽高，默认值为 '700px', '670px'
            //$grid->setDialogFormDimensions('50%', '50%');
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('brand', '品牌', [
                    1 => '华为',
                    2 => '小米',
                    3 => 'OPPO',
                    4 => 'vivo',
                ]);
                $selector->select('yanse', '颜色', [
                    1 => '<span style="display:inline-block;background-color:#FF0000;width:16px;height: 16px;"></span>',
                    2 => '<span style="display:inline-block;background-color:#3054dd;width:16px;height: 16px;"></span>',
                    3 => '<span style="display:inline-block;background-color:#ffb60f;width:16px;height: 16px;"></span>',
                    4 => '<span style="display:inline-block;background-color:#30ff48;width:16px;height: 16px;"></span>',
                ]);
            });
            $grid->column('id')->code()->sortable();
            $grid->column('label')->explode()->label();
            $grid->column('progressBar')->progressBar()->sortable();
            //$grid->column('video','视频')->video();
            $grid->column('label')->dot();
            $grid->column('expand')
                ->display(Factory::create()->name)
                ->expand(PostTable::make());
            $grid->column('select')->select(['GET', 'POST', 'PUT', 'DELETE']);
            $grid->column('switch')->switch();
            $grid->column('switchGroup', 'Switch Group')
                ->if(function () {
                    return $this->id != mt_rand(3, 5);
                })
                ->switchGroup(['is_new', 'is_hot', 'published'])
                ->else()
                ->display('<i>None</i>');

            $grid->column('checkbox')->checkbox(['GET', 'POST', 'PUT', 'DELETE']);
            $grid->column('radio')
                ->if(function () {
                    return $this->id != mt_rand(3, 5);
                })
                ->radio(['PHP', 'JAVA', 'GO', 'C'])
                ->else()
                ->display('<i>None</i>');

            // 额外列（测试多列在 iframe-tab 模式下的表现）
            $grid->column('status', '状态')->using([0 => '禁用', 1 => '启用'])->label([
                0 => 'danger',
                1 => 'success',
            ]);
            $grid->column('order', '排序')->editable();
            $grid->column('price', '价格')->display(function ($v) { return '¥' . number_format($v, 2); });
            $grid->column('stock', '库存')->progressBar('#5c6bc0');
            $grid->column('category', '分类')->label(['default' => 'default', '电子' => 'primary', '服装' => 'info', '食品' => 'success', '家居' => 'warning']);
            $grid->column('city', '城市');
            $grid->column('email', '邮箱')->copyable();
            $grid->column('phone', '电话')->copyable();
            $grid->column('address', '地址')->limit(20);
            $grid->column('weight', '重量(KG)')->display(function ($v) { return number_format($v, 1); });
            $grid->column('color', '颜色')->dot(['#FF0000' => '红色', '#3054dd' => '蓝色', '#ffb60f' => '黄色', '#30ff48' => '绿色', '#999' => '灰色']);
            $grid->column('source', '来源')->using(['web' => '网站', 'app' => 'APP', 'mini' => '小程序', 'h5' => 'H5']);
            $grid->column('ip', 'IP地址');
            $grid->column('remark', '备注')->limit(15);

            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($this->generate());

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append($this->buildPreviewButton());
            });

            // 过滤器
            $grid->filter(function (Grid\Filter $filter) {
                $group = function (Grid\Filter\Group $group) {
                    $group->equal('等于');
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('大于等于');
                    $group->ngt('小于等于');
                    $group->like('包含');
                    $group->startWith('包含（起始）');
                    $group->endWith('包含（结束）');
                    $group->match('正则');
                };

                $filter->group('id', $group)->width('350px');
                $filter->group('date', $group)->date()->width('350px');

                $filter->equal('select')->select(range(1, 10));
                $filter->in('multiple', 'Multiple Select')->multipleSelect(range(1, 10));
                $filter->between('between', 'Between')->datetime();

                $options = function ($keys) {
                    if (!$keys) return $keys;
                    $userModel = config('admin.database.users_model');

                    return $userModel::findOrFail($keys)->pluck('name', 'id');
                };

                $filter->equal('user', 'User')
                    ->selectTable(UserTable::make())
                    ->title('User')
                    ->model(Administrator::class)
                    ->width('300px');
            });
        });
    }

    public function update()
    {
        return [
            'status' => true,
            'message' => '修改成功',
        ];
    }

    /**
     * 生成假数据
     *
     * @return array
     */
    public function generate()
    {
        $faker = Factory::create();

        $data = [];

        $categories = ['电子', '服装', '食品', '家居', '默认'];
        $cities = ['北京', '上海', '广州', '深圳', '杭州', '成都', '武汉', '南京', '重庆', '西安'];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id' => $i+1,
                'label' => str_repeat($faker->name().',', mt_rand(1, 2)),
                'video' => 'https://demo.saishiyun.net/img/lsc0OW2bFX.mp4',
                'progressBar' => mt_rand(1, 100),
                'switch' => mt_rand(0, 1),
                'editable' => mt_rand(0, 14),
                'checkbox' => value(function () use ($faker) {
                    $values = [];
                    for ($j = 0; $j < mt_rand(1, 4); $j++) {
                        $values[] = mt_rand(0, 3);
                    }
                    return join(',', $values);
                }),
                'radio' => mt_rand(0, 3),
                'is_new' => mt_rand(0, 1),
                'is_hot' => mt_rand(0, 1),
                'published' => mt_rand(0, 1),
                'status' => mt_rand(0, 1),
                'order' => mt_rand(1, 100),
                'price' => mt_rand(100, 99999) / 10,
                'stock' => mt_rand(0, 500),
                'category' => $categories[array_rand($categories)],
                'city' => $cities[array_rand($cities)],
                'email' => $faker->safeEmail,
                'phone' => '1' . mt_rand(3, 9) . mt_rand(100000000, 999999999),
                'address' => $faker->address,
                'weight' => mt_rand(1, 5000) / 10,
                'color' => ['#FF0000', '#3054dd', '#ffb60f', '#30ff48', '#999'][array_rand([0,1,2,3,4])],
                'source' => ['web', 'app', 'mini', 'h5'][array_rand([0,1,2,3])],
                'ip' => mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(1, 254),
                'remark' => $faker->sentence,
            ];
        }

        return $data;
    }

    /**
     * 生成假数据
     *
     * @return array
     */
    protected function genernateNames()
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $data[] = $faker->name;
        }
        return $data;
    }
}
