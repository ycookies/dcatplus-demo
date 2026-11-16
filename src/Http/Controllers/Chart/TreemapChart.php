<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 树图 (Treemap) —— 矩形面积表达层级数值占比。
 *
 * v5 专属：v3 不支持。
 */
class TreemapChart extends AbstractApexChart
{
    public function label(): string
    {
        return '树图 Treemap (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'treemap',
                'height' => 350,
            ],
            'series' => [
                [
                    'data' => [
                        ['x' => '华东', 'y' => 35],
                        ['x' => '华南', 'y' => 28],
                        ['x' => '华北', 'y' => 22],
                        ['x' => '华中', 'y' => 18],
                        ['x' => '西南', 'y' => 14],
                        ['x' => '西北', 'y' => 11],
                        ['x' => '东北', 'y' => 9],
                    ],
                ],
            ],
            'title'  => ['text' => '区域销售额占比', 'align' => 'left'],
            'plotOptions' => [
                'treemap' => [
                    'distributed'   => true,
                    'enableShades'  => false,
                    'borderRadius'  => 4,
                ],
            ],
            'colors' => [
                '#5b73e8', '#34c38f', '#f1b44c', '#f46a6a',
                '#50a5f1', '#a461d8', '#6c757d',
            ],
            'legend' => ['show' => false],
        ];
    }
}
