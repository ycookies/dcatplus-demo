<?php

namespace Dcat\Admin\DcatplusDemo;

use Dcat\Admin\Extend\ServiceProvider;

class DcatplusDemoServiceProvider extends ServiceProvider {
    protected $js = [
        'js/index.js',
    ];
    protected $css = [
        'css/index.css',
    ];
    protected $menu = [
        [

            'title' => 'Dcat-plus 示例大全',
            'uri'   => 'dcatplus-demo',
            'icon'  => 'feather icon-monitor',
        ],[
            'parent' => 'Dcat-plus 示例大全', // 指定父级菜单
            'title'  => "<span class='text-danger'>扩展包说明</span>",
            'icon'   => 'feather icon-eye',
            'uri'    => 'dcatplus-demo',
        ], [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '页面布局',
            'icon'   => 'fa fa-cubes',
            'uri'    => 'dcatplus-demo/layout',
        ], [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '数据表格',
            'icon'   => 'feather icon-grid',
            'uri'    => '',
        ], [
            'parent' => '数据表格',
            'title'  => '默认表格',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/grid',
        ], [
            'parent' => '数据表格',
            'title'  => '组合表头',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/reports',
        ],[
            'parent' => '数据表格',
            'title'  => '合并单元格',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/merge-cell',
        ],[
            'parent' => '数据表格',
            'title'  => '固定列',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/fixed-columns',
        ],[
            'parent' => '数据表格',
            'title'  => '边框模式+异步加载',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/with-border',
        ],[
            'parent' => '数据表格',
            'title'  => '树表格',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/tree',
        ],[
            'parent' => '数据表格',
            'title'  => '筛选器',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/tables/selector',
        ],[
            'parent' => '数据表格',
            'title'  => '自定义视图',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/grid/custom',
        ],[
            'parent' => '数据表格',
            'title'  => '简化分页',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/tables/simple-pagination',
        ],[
            'parent' => '数据表格',
            'title'  => '行间距模式',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/row-space',
        ],
        // 数据表单
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '数据表单',
            'icon'   => 'feather icon-edit',
            'uri'    => '',
        ],[
            'parent' => '数据表单',
            'title'  => '新增字段 <span class="right badge badge-danger">New</span>',
            'icon'   => 'fa fa-plus-circle',
            'uri'    => 'dcatplus-demo/forms/append',
        ],[
            'parent' => '数据表单',
            'title'  => '表单字段',
            'icon'   => 'feather icon-edit-1',
            'uri'    => 'dcatplus-demo/forms',
        ],[
            'parent' => '数据表单',
            'title'  => '弹窗表单',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/form/modal',
        ],[
            'parent' => '数据表单',
            'title'  => '分步表单 <span class="right badge badge-danger">已集成</span>',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/form/step',
        ],[
            'parent' => '数据表单',
            'title'  => '表单动态显示',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/form/when',
        ],[
            'parent' => '数据表单',
            'title'  => '表单布局',
            'icon'   => 'feather icon-layout',
            'uri'    => '',
        ],[
            'parent' => '表单布局',
            'title'  => 'Column布局',
            'icon'   => 'feather icon-edit-1',
            'uri'    => 'dcatplus-demo/form/layout/column',
        ],[
            'parent' => '表单布局',
            'title'  => 'Block布局',
            'icon'   => 'feather icon-edit-1',
            'uri'    => 'dcatplus-demo/form/layout/block',
        ],[
            'parent' => '表单布局',
            'title'  => 'Tab布局',
            'icon'   => 'feather icon-edit-1',
            'uri'    => 'dcatplus-demo/form/layout/tab',
        ],[
            'parent' => '表单布局',
            'title'  => 'Row布局',
            'icon'   => 'feather icon-edit-1',
            'uri'    => 'dcatplus-demo/form/layout/row',
        ],
        // 数据详情
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '数据详情',
            'icon'   => 'feather icon-file-text',
            'uri'    => 'dcatplus-demo/data-detail',
        ],
        // 构建无菜单栏页面 (full)
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => 'full page',
            'icon'   => 'fa fa-cut',
            'uri'    => 'dcatplus-demo/full',
        ],
        // 页面组件
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '页面组件',
            'icon'   => 'fa-building',
            'uri'    => 'dcatplus-demo/full-widget',
        ],
        // Data From Api
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => 'Data From Api',
            'icon'   => 'fa fa-film',
            'uri'    => '',
        ],[
            'parent' => 'Data From Api',
            'title'  => 'In Theaters',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/movies/in-theaters',
        ],[
            'parent' => 'Data From Api',
            'title'  => 'Coming Soon',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/movies/coming-soon',
        ],[
            'parent' => 'Dcat-plus 示例大全',
            'title'  => 'Top 250',
            'icon'   => 'feather icon-menu',
            'uri'    => 'dcatplus-demo/movies/top250',
        ],
        // 编辑器
        [
            'parent' => 'Dcat-plus 示例大全',
            'title'  => '编辑器',
            'icon'   => 'fa-underline',
            'uri'    => '',
        ],[
            'parent' => '编辑器',
            'title'  => 'TinyMCE',
            'icon'   => '',
            'uri'    => 'dcatplus-demo/form/tinymce',
        ],[
            'parent' => '编辑器',
            'title'  => 'Markdown',
            'icon'   => '',
            'uri'    => 'dcatplus-demo/form/markdown',
        ],

    ];

    public function register() {
        //
    }

    public function init() {
        parent::init();

        //

    }

    public function settingForm() {
        return new Setting($this);
    }
}
