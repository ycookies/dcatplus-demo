<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 散点图 (Scatter) —— 二维点分布，用于相关性分析。
 */
class ScatterChart extends AbstractApexChart
{
    public function label(): string
    {
        return '散点图 Scatter';
    }

    public function chartOptions(): array
    {
        // 两组虚拟随机点
        $sample = function () {
            $points = [];
            for ($i = 0; $i < 20; $i++) {
                $points[] = [mt_rand(10, 95), mt_rand(10, 95)];
            }

            return $points;
        };

        return [
            'chart' => [
                'type'   => 'scatter',
                'height' => 350,
                'zoom'   => ['enabled' => true, 'type' => 'xy'],
            ],
            'series' => [
                ['name' => '样本 A', 'data' => $sample()],
                ['name' => '样本 B', 'data' => $sample()],
            ],
            'title'      => ['text' => '样本分布', 'align' => 'left'],
            'xaxis'      => ['tickAmount' => 10],
            'yaxis'      => ['tickAmount' => 7],
            'colors'     => ['#5b73e8', '#f46a6a'],
            'dataLabels' => ['enabled' => false],
        ];
    }
}
