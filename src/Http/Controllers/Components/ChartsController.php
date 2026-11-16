<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Components;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\AreaChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\BarChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\BoxPlotChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\BubbleChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\DumbbellChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\FunnelChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\GaugeChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\RangeAreaChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\RangeBarChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\SlopeChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\TreemapChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\ViolinChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\CandlestickChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\ChinaMapChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\ColumnChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\DonutChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\HeatmapChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\LineChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\PieChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\PolarAreaChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\RadialBarChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\RadarChart;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Chart\ScatterChart;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Routing\Controller;

/**
 * ApexCharts v5.16.0 完整示例集合。
 *
 * 聚合 Chart/ 目录下各类图表，用于一次性验证 v5 在框架内的渲染是否正常。
 * 切换版本见 config/admin.php 的 apexcharts_version。
 */
class ChartsController extends Controller
{
    /**
     * 所有展示的图表类型（顺序即页面顺序）。
     */
    protected function charts(): array
    {
        return [
            new LineChart(),
            new AreaChart(),
            new ColumnChart(),
            new BarChart(),
            new PieChart(),
            new DonutChart(),
            new RadialBarChart(),
            new RadarChart(),
            new PolarAreaChart(),
            new HeatmapChart(),
            new ScatterChart(),
            new BubbleChart(),
            new CandlestickChart(),
            // —— v5 专属（v3 不支持，标记 v5）——
            new BoxPlotChart(),
            new ViolinChart(),
            new TreemapChart(),
            new FunnelChart(),
            new RangeAreaChart(),
            new RangeBarChart(),
            new GaugeChart(),
            new SlopeChart(),
            new DumbbellChart(),
        ];
    }

    public function index(Content $content)
    {
        $version = config('admin.apexcharts_version', 'v3');

        return $content
            ->header('ApexCharts 示例')
            ->description('当前版本：'.$version.'（于 config/admin.php 的 apexcharts_version 切换）')
            ->breadcrumb(
                ['text' => 'Dcat-Plus 示例大全', 'url' => '/dcatplus-demo'],
                ['text' => 'ApexCharts 示例']
            )
            ->body($this->versionTip($version))
            ->body(function (Row $row) {
                $charts = $this->charts();
                $count = count($charts);
                // 两列布局展示，每行两个图表
                for ($i = 0; $i < $count; $i += 2) {
                    $left  = $charts[$i];
                    $right = $charts[$i + 1] ?? null;
                    $row->column(6, $left->box());
                    if ($right) {
                        $row->column(6, $right->box());
                    }
                }
            })
            // 中国地图单独占一整行（地图较宽，且基于 ECharts，独立于 ApexCharts）
            ->body(function (Row $row) {
                $row->column(12, (new ChinaMapChart())->box());
            });
    }

    /**
     * 版本提示条。
     */
    protected function versionTip(string $version)
    {
        if ($version === 'v5') {
            return Alert::make(
                '当前使用 ApexCharts v5.16.0。包含 13 个基础图表 + 9 个 v5 专属图表'
                .'（标题带 v5 标记的：BoxPlot / Violin / Treemap / Funnel / RangeArea / RangeBar / Gauge / Slope / Dumbbell），'
                .'全部渲染正常即表示 v5 适配完好。'
            )->info();
        }

        return Alert::make(
            '当前使用 ApexCharts v3.17.1（默认）。基础 13 个图表可正常渲染；'
            .'标题带 <b>v5</b> 标记的 9 个图表在 v3 下不支持（会显示为空白或报错），此为预期行为。'
            .'如需验证 v5.16.0，请设置 <code>ADMIN_APEXCHARTS_VERSION=v5</code> 并执行 '
            .'<code>php artisan admin:publish --assets --force</code>。'
        )->warning();
    }
}
