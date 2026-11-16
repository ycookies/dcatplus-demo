<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 热力图 (Heatmap) —— 二维矩阵强度，按色阶表达数值。
 */
class HeatmapChart extends AbstractApexChart
{
    public function label(): string
    {
        return '热力图 Heatmap';
    }

    public function chartOptions(): array
    {
        // 生成虚拟数据：5 名销售 × 7 天
        $names = ['张三', '李四', '王五', '赵六', '钱七'];
        $days  = ['周一', '周二', '周三', '周四', '周五', '周六', '周日'];
        $series = [];
        foreach ($names as $name) {
            $row = ['name' => $name, 'data' => []];
            foreach ($days as $_) {
                $row['data'][] = mt_rand(0, 100);
            }
            $series[] = $row;
        }

        return [
            'chart' => [
                'type'   => 'heatmap',
                'height' => 350,
            ],
            'series' => $series,
            'title'  => ['text' => '销售活跃度矩阵', 'align' => 'left'],
            'dataLabels' => ['enabled' => false],
            'plotOptions' => [
                'heatmap' => [
                    'radius'        => 4,
                    'colorScale'    => [
                        'ranges' => [
                            ['from' => 0,  'to' => 33,  'name' => '低', 'color' => '#f46a6a'],
                            ['from' => 34, 'to' => 66,  'name' => '中', 'color' => '#f1b44c'],
                            ['from' => 67, 'to' => 100, 'name' => '高', 'color' => '#34c38f'],
                        ],
                    ],
                ],
            ],
            'xaxis' => ['categories' => $days],
        ];
    }
}
