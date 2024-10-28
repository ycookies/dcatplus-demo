<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Actions\Grid;

use App\Admin\Forms\CashVerifyForm;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class CashVerify extends BatchAction
{
    protected $title = '提现审核';

    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null, $action = 1)
    {
        $this->title = $title;
        $this->action = $action;
    }

    public function render()
    {
        // 实例化表单类
        $form = CashVerifyForm::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->onLoad($this->getModalScript()) // 弹窗显示后往隐藏表单写入选中的ID
            ->button($this->title);
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#reset-password-id').val(key);
JS;
    }
}
