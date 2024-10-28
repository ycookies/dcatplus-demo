<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Faker\Factory;
use Illuminate\Routing\Controller;

class SparklineController extends Controller {
    public function index(Content $content) {
        return $content->header('Sparkline')
            // 添加面包屑导航
            ->breadcrumb(
                ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
                ['text' => '页面组件', 'url' => '/dcatplus-demo/full-widget'],
                ['text' => 'Sparkline']
            )
            ->body(
                Box::make('代码', new Code(__FILE__, 15, 35))
                    ->style('default')
            );
    }
}
