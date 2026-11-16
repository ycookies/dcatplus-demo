<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 气泡图 (Bubble) —— 散点 + 气泡大小表达第三维数据。
 */
class BubbleChart extends AbstractApexChart
{
    public function label(): string
    {
        return '气泡图 Bubble';
    }

    public function chartOptions(): array
    {
        // ApexCharts 气泡点格式：[x, y, z]，z 为气泡半径
        $gen = function ($base) {
            $points = [];
            for ($i = 1; $i <= 12; $i++) {
                $points[] = [$i, $base + mt_rand(-10, 10), mt_rand(5, 25)];
            }

            return $points;
        };

        return [
            'chart' => [
                'type'   => 'bubble',
                'height' => 350,
            ],
            'series' => [
                ['name' => '产品 A', 'data' => $gen(40)],
                ['name' => '产品 B', 'data' => $gen(70)],
                ['name' => '产品 C', 'data' => $gen(55)],
            ],
            'title'      => ['text' => '产品多维分布', 'align' => 'left'],
            'dataLabels' => ['enabled' => false],
            'fill'       => ['opacity' => 0.7],
            'colors'     => ['#5b73e8', '#34c38f', '#f1b44c'],
            'xaxis'      => ['tickAmount' => 12],
        ];
    }
}
