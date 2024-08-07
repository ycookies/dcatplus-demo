<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\Http\Controllers\UserController;

class RowSpaceController extends UserController
{
    use PreviewCode;

    protected $title = '表格行间距模式';

    public function grid()
    {
        return parent::grid()
            ->tableCollapse(false)
            ->tools($this->buildPreviewButton());
    }
}
