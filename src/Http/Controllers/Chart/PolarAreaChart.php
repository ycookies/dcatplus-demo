<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 极坐标图 (PolarArea) —— 扇形占比，半径无轴刻度。
 */
class PolarAreaChart extends AbstractApexChart
{
    public function label(): string
    {
        return '极坐标图 PolarArea';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'polarArea',
                'height' => 350,
            ],
            'series' => [14, 23, 21, 17, 15, 38],
            'labels' => ['周一', '周二', '周三', '周四', '周五', '周末'],
            'title'  => ['text' => '活跃时段分布', 'align' => 'left'],
            'colors' => ['#5b73e8', '#34c38f', '#f1b44c', '#f46a6a', '#50a5f1', '#a461d8'],
            'stroke' => ['colors' => ['#fff']],
            'legend' => ['position' => 'bottom'],
        ];
    }
}
