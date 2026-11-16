<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 环形图 (Donut) —— 中空饼图，可放中心汇总文案。
 */
class DonutChart extends AbstractApexChart
{
    public function label(): string
    {
        return '环形图 Donut';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'donut',
                'height' => 350,
            ],
            'series' => [44, 55, 41, 17],
            'labels' => ['搜索', '直接访问', '外链', '广告'],
            'title'  => ['text' => '流量来源', 'align' => 'left'],
            'colors' => ['#5b73e8', '#34c38f', '#f1b44c', '#f46a6a'],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size'       => '70%',
                        'labels'     => [
                            'show'  => true,
                            'total' => ['show' => true, 'label' => '总计'],
                        ],
                    ],
                ],
            ],
            'legend' => ['position' => 'bottom'],
        ];
    }
}
