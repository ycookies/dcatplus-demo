<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use RuntimeException;
use Throwable;

/**
 * JsonResponse 全指令演示表单.
 *
 * payload['mode'] 预置响应模式（页面每个直达按钮预置一种）；
 * 表单内也可用「模式选择器」自由切换。handle() 按 mode 返回对应的
 * JsonResponse 调用链——覆盖 JsonResponse 全部功能性方法。
 */
class JsonResponseDemoForm extends Form implements LazyRenderable
{
    use LazyWidget;

    public static array $modes = [
        'success'          => 'success(msg) —— 仅提示，不刷新',
        'success_refresh'  => 'success(msg)->refresh() —— 整页重载',
        'refresh'          => 'refresh() —— 仅刷新指令（无提示）',
        'info'             => 'info(msg) —— info 类型 toast',
        'warning'          => 'warning(msg) —— warning 类型 toast',
        'error'            => 'error(msg) —— 错误提示，弹窗保留',
        'error_refresh'    => 'error(msg)->refresh() —— error 链路 then 不执行',
        'alert'            => 'success(msg)->alert() —— SweetAlert 弹窗',
        'alert_detail'     => 'success(msg)->alert()->detail() —— 弹窗+正文',
        'timeout'          => 'success(msg)->timeout(2) —— toast 2 秒消失',
        'download'         => 'success(msg)->download(url) —— 新窗口下载',
        'redirect'         => 'success(msg)->redirect(auth/users) —— 整页跳转',
        'location'         => 'success(msg)->location(auth/menu) —— 整页跳转',
        'location_null'    => 'success(msg)->location(null) —— 整页重载',
        'script'           => 'success(msg)->script(js) —— 执行自定义 JS',
        'data'             => 'success(msg)->data(custom) —— 携带自定义数据',
        'validation'       => 'withValidation(errors) —— 422 字段错误回显',
        'exception'        => 'withException(e) —— 异常转错误响应',
        'status_code'      => 'statusCode(422) —— 自定义 HTTP 状态码',
        'if_magic'         => 'successIf/errorIf —— 条件魔法方法',
        'status_false'     => 'status(false) —— 失败响应',
        'flash_with'       => 'with(key, value) —— session flash',
    ];

    public function handle(array $input): JsonResponse
    {
        $mode = $input['mode'] ?? 'success';
        $msg = ($input['message'] ?? '') ?: '演示消息';
        $r = JsonResponse::make();

        switch ($mode) {
            case 'success_refresh':
                return $r->success($msg)->refresh();
            case 'refresh':
                return $r->refresh();
            case 'info':
                return $r->info($msg);
            case 'warning':
                return $r->warning($msg);
            case 'error':
                return $r->error($msg);
            case 'error_refresh':
                // 已知语义差异：error 链路 then 不执行（不刷新）
                return $r->error($msg)->refresh();
            case 'alert':
                return $r->success($msg)->alert();
            case 'alert_detail':
                return $r->success($msg)->alert()->detail('这里是 SweetAlert 的正文说明（detail）');
            case 'timeout':
                return $r->success($msg)->timeout(2);
            case 'download':
                return $r->success($msg)->download('https://www.dcat-admin.com/favicon.ico');
            case 'redirect':
                return $r->success($msg)->redirect('auth/users');
            case 'location':
                return $r->success($msg)->location('auth/menu');
            case 'location_null':
                return $r->success($msg)->location();
            case 'script':
                return $r->success($msg)->script('window.__jsDemoRan = "script-ok-42"; Dcat.info("script 已执行")');
            case 'data':
                return $r->success($msg.'（data 携带自定义数据，可被前端 success 回调读取）')->data(['custom' => ['a' => 1, 'b' => 'two']]);
            case 'validation':
                // 错误键对应表单实际字段（mode/message），错误信息回显在字段下方
                return $r->withValidation([
                    'mode'    => ['请选择有效的响应模式'],
                    'message' => ['提示文本不能包含敏感词'],
                ]);
            case 'exception':
                try {
                    throw new RuntimeException('模拟业务异常 XYZ');
                } catch (Throwable $e) {
                    return $r->withException($e);
                }
            case 'status_code':
                return $r->statusCode(422)->error('HTTP 状态码 422 模拟');
            case 'if_magic':
                // 条件成立才应用：message 有值 → successIf 生效；否则 errorIf 生效
                return $r->successIf(! empty($msg) && $msg !== '演示消息', 'successIf 命中（你修改了文本）')
                    ->errorIf(empty($msg) || $msg === '演示消息', 'errorIf 命中（文本为默认值）');
            case 'status_false':
                return $r->status(false)->message('status(false) 失败响应');
            case 'flash_with':
                return $r->success('flash 已写入 session（下一次整页请求可见）')->with(['demo_flash' => 'flash-value-42']);
        }

        return $r->success($msg);
    }

    public function form()
    {
        $this->select('mode', '响应模式')
            ->options(static::$modes)
            ->default($this->payload['mode'] ?? 'success');
        $this->text('message', '提示文本')->default('演示消息');
    }
}
