<?php

use Dcat\Admin\DcatplusDemo\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*Route::get('dcatplus-demo', Controllers\DcatplusDemoController::class.'@index');
Route::get('dcatplus-demo/components/pricing-card', Controllers\Components\PricingCardController::class.'@index');
Route::get('dcatplus-demo/components/pricing-card/preview', Controllers\Components\PricingCardController::class.'@preview');*/
Route::prefix('dcatplus-demo')
    ->namespace('Dcat\Admin\DcatplusDemo\Http\Controllers')
    ->group(function () {
        Route::get('/', DcatplusDemoController::class.'@index');
        Route::get('components/pricing-card', Components\PricingCardController::class.'@index');
        Route::get('components/pricing-card/preview', Components\PricingCardController::class.'@preview');

        # 布局
        Route::get('layout', 'Full\LayoutController@index');

        // 报表示例
        Route::get('reports', 'Full\ReportController@index');
        Route::get('reports/preview', 'Full\ReportController@preview');

        // 固定列功能示例
        Route::get('fixed-columns', 'Full\FixedController@index');
        Route::get('fixed-columns/preview', 'Full\FixedController@preview');

        // 固定列功能示例
        Route::get('with-border', 'Full\BorderTableController@index');
        Route::get('with-border/preview', 'Full\BorderTableController@preview');
        // 行间距
        Route::get('row-space', 'Full\RowSpaceController@index');
        Route::get('row-space/preview', 'Full\RowSpaceController@preview');
        // 自定义表格视图
        Route::get('grid/custom', 'Full\CustomGridController@index');
        Route::get('grid/custom/preview', 'Full\CustomGridController@preview');

        // simple page
        Route::get('full', 'Full\FullPageController@index');

        Route::get('tree', 'Full\GridTreeController@index');
        Route::get('tree/preview', 'Full\GridTreeController@preview');


        // grid
        Route::resource('grid', 'Full\GridController', ['except' => ['create', 'show', 'destroy']]);
        Route::get('grid/preview', 'Full\GridController@preview');

        // form
        Route::get('forms', 'Full\FormController@index');
        Route::get('forms/preview', 'Full\FormController@preview');

        // 分步表单
        Route::get('form/step/preview', 'Full\StepFormController@preview');
        Route::get('form/step', 'Full\StepFormController@index');
        Route::post('form/step', 'Full\StepFormController@store');

        // 动态显示表单
        Route::get('form/when/preview', 'Full\FormWhenController@preview');
        Route::get('form/when', 'Full\FormWhenController@index');
        Route::post('form/when', 'Full\FormWhenController@store');

        // 表单弹窗
        Route::get('form/modal', 'Full\ModalFormController@index');
        Route::get('form/modal/preview', 'Full\ModalFormController@preview');

        Route::get('form/tinymce', 'Full\EditorController@tinymce');
        Route::get('form/tinymce/preview', 'Full\EditorController@preview');
        Route::get('form/markdown', 'Full\EditorController@markdown');

        Route::get('form/layout/column', 'Full\FormColumnController@create');
        Route::get('form/layout/column/preview', 'Full\FormColumnController@preview');

        Route::get('form/layout/block', 'Full\FormBlockController@create');
        Route::get('form/layout/block/preview', 'Full\FormBlockController@preview');

        Route::get('form/layout/tab', 'Full\FormTabController@create');
        Route::get('form/layout/tab/preview', 'Full\FormTabController@preview');

        Route::get('form/layout/row', 'Full\FormRowController@create');
        Route::get('form/layout/row/preview', 'Full\FormRowController@preview');

        // 页面组件
        Route::get('full-widget', 'Full\FullWidgetController@index');

        # 数据详情
        Route::get('data-detail', 'Full\DataDetailController@index');
        Route::get('data-detail/preview', 'Full\DataDetailController@preview');

        # 表格
        Route::get('tables/selector', 'Full\SelectorController@index');
        Route::get('tables/selector/preview', 'Full\SelectorController@preview');
        Route::get('tables/simple-pagination', 'Full\SimplePatinationController@index');
        Route::get('tables/simple-pagination/preview', 'Full\SimplePatinationController@preview');

        // 其余组件
        Route::get('components/charts', 'Components\ChartController@index');
        Route::get('components/charts/preview', 'Components\ChartController@preview');
        Route::get('components/card-box', 'Components\BoxController@index');
        Route::get('components/alert', 'Components\AlertController@index');
        Route::get('components/tab-button', 'Components\TabController@index');
        Route::get('components/markdown', 'Components\MarkdownController@index');
        Route::get('components/layer', 'Components\LayerController@index');
        Route::get('components/checkbox-radio', 'Components\CheckboxController@index');
        Route::get('components/checkbox-radio/preview', 'Components\CheckboxController@preview');
        Route::get('components/tooltip', 'Components\TooltipController@index');
        Route::get('components/dropdown-menu', 'Components\DropdownMenuController@index');
        Route::get('components/loading', 'Components\LoadingController@index');
        Route::get('components/loading/preview', 'Components\LoadingController@preview');
        Route::get('components/metric-cards', 'Components\MetricCardController@index');
        Route::get('components/metric-cards/preview', 'Components\MetricCardController@preview');
        Route::get('components/carousel', 'Components\CarouselController@index');
        Route::get('components/carousel/preview', 'Components\CarouselController@preview');
        Route::get('components/collapse', 'Components\CollapseController@index');
        Route::get('components/collapse/preview', 'Components\CollapseController@preview');
        Route::get('components/list-group', 'Components\ListGroupController@index');
        Route::get('components/list-group/preview', 'Components\ListGroupController@preview');

        Route::get('components/btn-group', 'Components\BtnGroupController@index');
        Route::get('components/btn-group/preview', 'Components\BtnGroupController@preview');

        Route::get('components/media-list', 'Components\MediaListController@index');
        Route::get('components/media-list/preview', 'Components\MediaListController@preview');

        Route::get('components/card-widget', 'Components\CardWidgetController@index');
        Route::get('components/card-widget/preview', 'Components\CardWidgetController@preview');

        Route::get('components/timeline', 'Components\TimelineController@index');
        Route::get('components/timeline/preview', 'Components\TimelineController@preview');
        Route::get('components/infolist', 'Components\InfolistController@index');
        Route::get('components/infolist/preview', 'Components\InfolistController@preview');
        Route::get('components/pricing-card', 'Components\PricingCardController@index');
        Route::get('components/pricing-card/preview', 'Components\PricingCardController@preview');


        Route::get('components/modal', 'Components\ModalController@index');
        Route::get('components/modal/preview', 'Components\ModalController@preview');
        Route::get('components/navbar', 'Components\NavbarController@index');
        Route::get('components/cover-card', 'Components\CoverCardController@index');
        Route::get('components/cover-card/preview', 'Components\CoverCardController@preview');

        // movies
        Route::get('movies/coming-soon', 'Movies\ComingSoonController@index');
        Route::get('movies/coming-soon/preview', 'Movies\ComingSoonController@preview');
        Route::resource('movies/in-theaters', 'Movies\InTheaterController', ['except' => ['create', 'show']]);
        Route::get('movies/in-theaters/preview', 'Movies\InTheaterController@preview');
        Route::get('movies/top250', 'Movies\Top250Controller@index');
        Route::get('movies/top250/preview', 'Movies\Top250Controller@preview');



        //Route::get('/extensions/ueditor', 'Full\UeditorController@index');
        //Route::get('/extensions/ueditor/preview', 'Full\UeditorController@preview');

    });

/*Route::group([
    'prefix'     => 'dcatplus-demo',
    'namespace'  => 'Dcat\Admin\DcatplusDemo\Http\Controllers',
], function (Router $router) {
    $router->get('/', DcatplusDemoController::class.'@index');*/
    //$router->get('components/pricing-card', Controllers\Components\PricingCardController::class.'@index');
    //$router->get('components/pricing-card/preview', Controllers\Components\PricingCardController::class.'@preview');


    /*// 布局示例
    $router->get('layout', 'LayoutController@index');
    // 报表示例
    $router->get('reports', 'ReportController@index');
    $router->get('reports/preview', 'ReportController@preview');
    // 固定列功能示例
    $router->get('fixed-columns', 'FixedController@index');
    $router->get('fixed-columns/preview', 'FixedController@preview');
    // 固定列功能示例
    $router->get('with-border', 'BorderTableController@index');
    $router->get('with-border/preview', 'BorderTableController@preview');
    // 行间距
    $router->get('row-space', 'RowSpaceController@index');
    $router->get('row-space/preview', 'RowSpaceController@preview');
    // 自定义表格视图
    $router->get('grid/custom', 'CustomGridController@index');
    $router->get('grid/custom/preview', 'CustomGridController@preview');

    // simple page
    $router->get('full', 'FullPageController@index');

    $router->get('tree', 'GridTreeController@index');
    $router->get('tree/preview', 'GridTreeController@preview');

    // grid
    $router->resource('components/grid', 'GridController', ['except' => ['create', 'show', 'destroy']]);
    $router->get('components/grid/preview', 'GridController@preview');
    // form
    $router->get('form', 'FormController@index');
    $router->post('form', 'FormController@index');
    $router->get('form/preview', 'FormController@preview');

    // 分步表单
    $router->get('form/step/preview', 'StepFormController@preview');
    $router->get('form/step', 'StepFormController@index');
    $router->post('form/step', 'StepFormController@store');

    // 动态显示表单
    $router->get('form/when/preview', 'FormWhenController@preview');
    $router->get('form/when', 'FormWhenController@index');
    $router->post('form/when', 'FormWhenController@store');

    // 表单弹窗
    $router->get('form/modal', 'ModalFormController@index');
    $router->get('form/modal/preview', 'ModalFormController@preview');

    $router->get('form/tinymce', 'EditorController@tinymce');
    $router->get('form/tinymce/preview', 'EditorController@preview');
    $router->get('form/markdown', 'EditorController@markdown');

    $router->get('form/layout/column', 'FormColumnController@create');
    $router->get('form/layout/column/preview', 'FormColumnController@preview');

    $router->get('form/layout/block', 'FormBlockController@create');
    $router->get('form/layout/block/preview', 'FormBlockController@preview');

    $router->get('form/layout/tab', 'FormTabController@create');
    $router->get('form/layout/tab/preview', 'FormTabController@preview');

    $router->get('form/layout/row', 'FormRowController@create');
    $router->get('form/layout/row/preview', 'FormRowController@preview');

    // 表格
    $router->get('tables/selector', 'SelectorController@index');
    $router->get('tables/selector/preview', 'SelectorController@preview');
    $router->get('tables/simple-pagination', 'SimplePatinationController@index');
    $router->get('tables/simple-pagination/preview', 'SimplePatinationController@preview');

    // 其余组件
    $router->get('full-widget', 'FullWidgetController@index');
    $router->get('components/charts', 'Components\ChartController@index');
    $router->get('components/charts/preview', 'Components\ChartController@preview');
    $router->get('components/card-box', 'Components\BoxController@index');
    $router->get('components/alert', 'Components\AlertController@index');
    $router->get('components/tab-button', 'Components\TabController@index');
    $router->get('components/markdown', 'Components\MarkdownController@index');
    $router->get('components/layer', 'Components\LayerController@index');
    $router->get('components/checkbox-radio', 'Components\CheckboxController@index');
    $router->get('components/checkbox-radio/preview', 'Components\CheckboxController@preview');
    $router->get('components/tooltip', 'Components\TooltipController@index');
    $router->get('components/dropdown-menu', 'Components\DropdownMenuController@index');
    $router->get('components/loading', 'Components\LoadingController@index');
    $router->get('components/loading/preview', 'Components\LoadingController@preview');
    $router->get('components/metric-cards', 'Components\MetricCardController@index');
    $router->get('components/metric-cards/preview', 'Components\MetricCardController@preview');
    $router->get('components/carousel', 'Components\CarouselController@index');
    $router->get('components/carousel/preview', 'Components\CarouselController@preview');
    $router->get('components/collapse', 'Components\CollapseController@index');
    $router->get('components/collapse/preview', 'Components\CollapseController@preview');
    $router->get('components/list-group', 'Components\ListGroupController@index');
    $router->get('components/list-group/preview', 'Components\ListGroupController@preview');

    $router->get('components/btn-group', 'Components\BtnGroupController@index');
    $router->get('components/btn-group/preview', 'Components\BtnGroupController@preview');

    $router->get('components/media-list', 'Components\MediaListController@index');
    $router->get('components/media-list/preview', 'Components\MediaListController@preview');

    $router->get('components/card-widget', 'Components\CardWidgetController@index');
    $router->get('components/card-widget/preview', 'Components\CardWidgetController@preview');

    $router->get('components/timeline', 'Components\TimelineController@index');
    $router->get('components/timeline/preview', 'Components\TimelineController@preview');
    $router->get('components/infolist', 'Components\InfolistController@index');
    $router->get('components/infolist/preview', 'Components\InfolistController@preview');
    $router->get('components/pricing-card', 'Components\PricingCardController@index');
    $router->get('components/pricing-card/preview', 'Components\PricingCardController@preview');


    $router->get('components/modal', 'Components\ModalController@index');
    $router->get('components/modal/preview', 'Components\ModalController@preview');

    // movies
    $router->get('movies/coming-soon', 'Movies\ComingSoonController@index');
    $router->get('movies/coming-soon/preview', 'Movies\ComingSoonController@preview');
    $router->resource('movies/in-theaters', 'Movies\InTheaterController', ['except' => ['create', 'show']]);
    $router->get('movies/in-theaters/preview', 'Movies\InTheaterController@preview');
    $router->get('movies/top250', 'Movies\Top250Controller@index');
    $router->get('movies/top250/preview', 'Movies\Top250Controller@preview');

    $router->get('/extensions/ueditor', 'Extensions\UeditorController@index');
    $router->get('/extensions/ueditor/preview', 'Extensions\UeditorController@preview');

    # helpers
    $router->get('helpers-tools/scaffold', 'Helpers\ScaffoldController@index');
    $router->post('helpers-tools/scaffold', 'Helpers\ScaffoldController@store');
    $router->post('helpers-tools/scaffold/table', 'Helpers\ScaffoldController@table');
    $router->get('helpers-tools/icons', 'Helpers\IconController@index');
    $router->resource('helpers-tools/extensions', 'Helpers\ExtensionController'); // ['only' => ['index', 'store', 'update']]

    $router->any('demo-croppers','DemoCropperController@index');

    # 全局配置
    $router->get('settings', 'Setting\SettingsController@index');
    $router->get('settings/oss', 'Setting\OssController@index');
    $router->get('settings/pay', 'Setting\PayController@index');

    # 数据看板
    $router->get('datav', 'DataVController@index');

    # 数据详情
    $router->get('data-detail', 'DataDetailController@index');

    $router->get('amis', 'AmisController@index');*/

    # plugins
    //$router->resource('chaog/partner', 'ChaogPartnerController');

    # 开发工具
    /*$router->get('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@index');
    $router->post('helpers/scaffold', 'Dcat\Admin\Http\Controllers\ScaffoldController@store');
    $router->post('helpers/scaffold/table', 'Dcat\Admin\Http\Controllers\ScaffoldController@table');
    $router->get('helpers/icons', 'Dcat\Admin\Http\Controllers\IconController@index');*/

//});