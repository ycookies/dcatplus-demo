<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use App\Models\MemberUser;
use Dcat\Admin\Http\JsonResponse;
class UserProfile extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle(array $input)
    {
        //return JsonResponse::make()->error('保存失败');
        //return JsonResponse::make()->success('保存失败');
        //return JsonResponse::make()->success('保存失败')->refresh();
        return JsonResponse::make()->success('保存失败')->refresh();
        //return JsonResponse::make()->success('保存成功123')->download('https://sh-api.tiyouzaixian.com/2025%E5%B9%B4%E2%80%9C%E5%8D%97%E5%B1%B1%E8%B7%83%E5%BE%8B%EF%BC%8C%E7%BB%B3%E5%8A%A8%E5%85%A8%E5%9F%8E%E2%80%9D%E6%B7%B1%E5%9C%B3%E5%8D%97%E5%B1%B1%E5%8C%BA%E4%B8%AD%E5%B0%8F%E5%AD%A6%E7%94%9F%E5%85%A8%E5%91%98%E8%B7%B3%E7%BB%B3%E5%A4%A7%E8%B5%9B-%E5%88%9D%E4%B8%AD%E7%BB%84PLsTfFh9Rd2x8FCHQsrU.zip');
    }

    public function default()
    {
        return [
            // 展示上个页面传递过来的值
            'name' => $this->payload['name'] ?? '',
        ];
    }

    public function form()
    {
        $botData = MemberUser::query()->pluck('username', 'id')->toArray();
        $this->text('name', trans('admin.name'))->required()->help('用户昵称');
        $this->image('avatar', trans('admin.avatar'))->autoUpload();
        $this->select('gender', trans('admin.gender'))->options([
            0 => '保密',
            1 => '男',
            2 => '女',
        ]);
        // $this->select('copy_bot_rid', '来源机器人')
        //     ->options($botData)
        //     ->required()
        //     ->help('从此机器人的菜单配置中提取');
        $this->password('password', trans('admin.password'))
            ->minLength(5)
            ->maxLength(20)
            ->customFormat(function ($v) {
                if ($v == $this->password) {
                    return;
                }

                return $v;
            })
            ->help('请输入5-20个字符');
        $this->password('password_confirmation', trans('admin.password_confirmation'))
            ->same('password')
            ->help('请输入确认密码');
    }
}
