<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Renderable;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Widgets\Charts\Bar;
use Dcat\Admin\Support\LazyRenderable;

class BarChart extends LazyRenderable
{
    public function render()
    {
        return Bar::make();
    }
}
