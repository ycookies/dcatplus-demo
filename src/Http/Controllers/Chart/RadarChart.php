<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 雷达图 (Radar) —— 多维度能力对比。
 */
class RadarChart extends AbstractApexChart
{
    public function label(): string
    {
        return '雷达图 Radar';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'radar',
                'height' => 350,
            ],
            'series' => [
                ['name' => '产品 A', 'data' => [80, 50, 30, 40, 100, 20]],
            ],
            'title'  => ['text' => '产品能力评估', 'align' => 'left'],
            'xaxis'  => [
                'categories' => ['性能', '价格', '易用性', '功能', '服务', '口碑'],
            ],
            'colors' => ['#5b73e8'],
            'fill'   => ['opacity' => 0.3],
            'markers' => ['size' => 4],
        ];
    }
}
