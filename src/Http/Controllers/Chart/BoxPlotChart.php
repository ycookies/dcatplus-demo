<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 箱线图 (BoxPlot) —— 展示分布的五数概括（min/Q1/median/Q3/max）。
 *
 * v5 专属：v3 不支持。
 */
class BoxPlotChart extends AbstractApexChart
{
    public function label(): string
    {
        return '箱线图 BoxPlot (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        // 数据格式：[min, Q1, median, Q3, max]
        $cats = ['1月', '2月', '3月', '4月', '5月', '6月'];
        $data = [
            [54, 66, 69, 75, 88],
            [43, 65, 69, 76, 81],
            [31, 39, 45, 51, 59],
            [24, 34, 41, 49, 64],
            [19, 25, 33, 41, 56],
            [12, 25, 39, 52, 73],
        ];

        return [
            'chart' => [
                'type'   => 'boxPlot',
                'height' => 350,
            ],
            'series' => [
                ['name' => '销售额分布', 'data' => array_map(function ($c, $d) {
                    return ['x' => $c, 'y' => $d];
                }, $cats, $data)],
            ],
            'title'  => ['text' => '月度销售额分布', 'align' => 'left'],
            'plotOptions' => [
                'boxPlot' => ['colors' => ['upper' => '#5b73e8', 'lower' => '#f1b44c']],
            ],
            'colors' => ['#5b73e8'],
        ];
    }
}
