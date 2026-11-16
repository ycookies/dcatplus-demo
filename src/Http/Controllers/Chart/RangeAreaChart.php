<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 范围面积图 (RangeArea) —— 用上下界区间表达波动范围，常配合折线表达预测/不确定区间。
 *
 * v5 专属：v3 不支持。
 * 数据格式：y 为 [min, max]。
 */
class RangeAreaChart extends AbstractApexChart
{
    public function label(): string
    {
        return '范围面积图 RangeArea (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        $cats  = ['周一', '周二', '周三', '周四', '周五', '周六', '周日'];
        $temps = [[18, 26], [19, 28], [21, 30], [20, 27], [17, 24], [16, 22], [15, 20]];
        $range = [];
        $line  = [];
        foreach ($cats as $i => $day) {
            $range[] = ['x' => $day, 'y' => [$temps[$i][0], $temps[$i][1]]];
            $line[]  = ['x' => $day, 'y' => (int) round(($temps[$i][0] + $temps[$i][1]) / 2)];
        }

        return [
            'chart' => [
                'type'   => 'rangeArea',
                'height' => 350,
            ],
            'series' => [
                ['type' => 'rangeArea', 'name' => '温度区间', 'data' => $range],
                ['type' => 'line',      'name' => '平均温度', 'data' => $line],
            ],
            'title'      => ['text' => '每日温度区间', 'align' => 'left'],
            'dataLabels' => ['enabled' => false],
            'stroke'     => ['curve' => 'smooth', 'width' => [0, 3]],
            'colors'     => ['#e3e6f0', '#5b73e8'],
            'fill'       => ['opacity' => [0.6, 1]],
            'markers'    => ['size' => [0, 4]],
        ];
    }
}
