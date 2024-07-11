<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Movies;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Top250;
use Dcat\Admin\Grid;

class Top250Controller extends ComingSoonController
{
    protected $header = 'Top250';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($repository = null)
    {
        return parent::grid(new Top250());
    }
}
