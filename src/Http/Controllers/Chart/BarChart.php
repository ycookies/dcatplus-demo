<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 条形图 (Bar) —— 横向条柱，适合长名称分类对比。
 */
class BarChart extends AbstractApexChart
{
    public function label(): string
    {
        return '条形图 Bar';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'bar',
                'height' => 350,
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal'  => true,
                    'borderRadius' => 4,
                ],
            ],
            'series' => [
                ['name' => '用户数', 'data' => [400, 430, 448, 470, 540, 580, 690, 1100, 1200]],
            ],
            'title'  => ['text' => '城市用户分布', 'align' => 'left'],
            'xaxis'  => [
                'categories' => ['北京', '上海', '广州', '深圳', '杭州', '成都', '武汉', '南京', '西安'],
            ],
            'colors' => ['#50a5f1'],
            'dataLabels' => ['enabled' => true],
        ];
    }
}
