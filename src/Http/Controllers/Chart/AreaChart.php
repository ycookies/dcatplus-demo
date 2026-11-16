<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 面积图 (Area) —— 渐变填充、平滑曲线，常用于趋势可视化。
 */
class AreaChart extends AbstractApexChart
{
    public function label(): string
    {
        return '面积图 Area';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'area',
                'height' => 350,
            ],
            'series' => [
                ['name' => '订单量', 'data' => [31, 40, 28, 51, 42, 109, 100]],
            ],
            'title'      => ['text' => '每日订单量', 'align' => 'left'],
            'dataLabels' => ['enabled' => false],
            'stroke'     => ['curve' => 'smooth'],
            'xaxis'      => [
                'categories' => ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            ],
            'fill' => [
                'type'    => 'gradient',
                'gradient' => [
                    'shadeIntensity' => 1,
                    'opacityFrom'    => 0.4,
                    'opacityTo'      => 0.1,
                    'stops'          => [0, 90, 100],
                ],
            ],
            'colors' => ['#34c38f'],
        ];
    }
}
