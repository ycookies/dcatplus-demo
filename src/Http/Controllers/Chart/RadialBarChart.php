<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Support\JavaScript;

/**
 * 径向柱图 (RadialBar) —— 环形进度/百分比，常用于 KPI。
 */
class RadialBarChart extends AbstractApexChart
{
    public function label(): string
    {
        return '径向柱图 RadialBar';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'radialBar',
                'height' => 350,
            ],
            'series' => [67, 84, 72],
            'labels' => ['转化率', '留存率', '活跃度'],
            'title'  => ['text' => '核心指标达成', 'align' => 'left'],
            'colors' => ['#5b73e8', '#34c38f', '#f1b44c'],
            'plotOptions' => [
                'radialBar' => [
                    'startAngle' => -135,
                    'endAngle'   => 135,
                    'hollow'     => ['size' => '55%'],
                    'dataLabels' => [
                        'name' => ['offsetY' => -10],
                        'value' => [
                            'offsetY'   => 6,
                            // formatter 必须是 JS 函数，不能写字符串字面量
                            'formatter' => JavaScript::make('function (val) { return val + "%"; }'),
                        ],
                    ],
                    'track' => ['background' => '#e3e6f0'],
                ],
            ],
            'legend' => ['position' => 'bottom'],
        ];
    }
}
