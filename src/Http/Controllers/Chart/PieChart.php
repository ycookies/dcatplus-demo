<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 饼图 (Pie) —— 占比分布。
 */
class PieChart extends AbstractApexChart
{
    public function label(): string
    {
        return '饼图 Pie';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'pie',
                'height' => 350,
            ],
            'series' => [44, 55, 13, 43, 22],
            'labels' => ['团队 A', '团队 B', '团队 C', '团队 D', '团队 E'],
            'title'  => ['text' => '渠道占比', 'align' => 'left'],
            'colors' => ['#5b73e8', '#34c38f', '#f1b44c', '#f46a6a', '#50a5f1'],
            'legend' => ['position' => 'bottom'],
            'responsive' => [
                [
                    'breakpoint' => 480,
                    'options'    => ['legend' => ['position' => 'bottom']],
                ],
            ],
        ];
    }
}
