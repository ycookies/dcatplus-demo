<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 柱状图 (Column) —— 竖向条柱，多系列分组对比。
 */
class ColumnChart extends AbstractApexChart
{
    public function label(): string
    {
        return '柱状图 Column';
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
                    'horizontal'  => false,
                    'columnWidth' => '55%',
                    'borderRadius' => 4,
                ],
            ],
            'series' => [
                ['name' => '本季度', 'data' => [44, 55, 57, 56, 61, 58, 63, 60]],
                ['name' => '上季度', 'data' => [76, 85, 101, 98, 87, 105, 91, 114]],
            ],
            'title'  => ['text' => '季度销售额对比', 'align' => 'left'],
            'xaxis'  => [
                'categories' => ['产品A', '产品B', '产品C', '产品D', '产品E', '产品F', '产品G', '产品H'],
            ],
            'dataLabels' => ['enabled' => false],
            'colors' => ['#5b73e8', '#e3e6f0'],
            'stroke' => ['show' => true, 'width' => 2, 'colors' => ['transparent']],
        ];
    }
}
