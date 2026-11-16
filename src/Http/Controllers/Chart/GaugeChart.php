<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Support\JavaScript;

/**
 * 仪表盘 (Gauge) —— 半圆指针式进度表，常用于单值 KPI 达成度。
 *
 * v5 专属：v3 不支持独立 gauge type。
 * 实现方式：chart.type='gauge'（v5 内部走 radialBar + gauge 默认：半圆、中心大数值）。
 *
 * @see https://apexcharts.com/docs/chart-types/gauge-chart/
 */
class GaugeChart extends AbstractApexChart
{
    public function label(): string
    {
        return '仪表盘 Gauge (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'gauge',
                'height' => 350,
            ],
            'series' => [76],  // 单值：达成率
            'plotOptions' => [
                'radialBar' => [
                    'startAngle' => -135,
                    'endAngle'   => 135,
                    'min'        => 0,
                    'max'        => 100,
                    'hollow'     => ['size' => '60%'],
                    'track'      => ['background' => '#e3e6f0', 'strokeWidth' => '100%', 'margin' => 5],
                    'dataLabels' => [
                        'name'  => ['show' => false],
                        'value' => [
                            'offsetY'   => 8,
                            'fontSize'  => '32px',
                            'fontWeight' => 600,
                            // 仪表盘数值后缀 %，formatter 必须是 JS 函数
                            'formatter' => JavaScript::make('function (val) { return val + "%"; }'),
                        ],
                    ],
                ],
            ],
            'title'  => ['text' => '月度目标达成率', 'align' => 'left'],
            'colors' => ['#34c38f'],
            'fill'   => ['type' => 'gradient', 'gradient' => [
                'shade'      => 'dark',
                'type'       => 'horizontal',
                'shadeIntensity' => 0.5,
                'gradientToColors' => ['#5b73e8'],
                'stops'      => [0, 100],
            ]],
        ];
    }
}
