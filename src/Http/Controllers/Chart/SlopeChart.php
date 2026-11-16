<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 坡图 (Slope Chart) —— 对比两个时间点的多类别数值变化（升降趋势）。
 *
 * v5 专属：v3 不支持。
 * 实现方式：chart.type=line + plotOptions.line.isSlopeChart=true
 */
class SlopeChart extends AbstractApexChart
{
    public function label(): string
    {
        return '坡图 Slope (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'line',
                'height' => 350,
            ],
            'plotOptions' => [
                'line' => ['isSlopeChart' => true],
            ],
            'series' => [
                ['name' => '北方大区', 'data' => [42, 58]],
                ['name' => '南方大区', 'data' => [65, 49]],
                ['name' => '东部大区', 'data' => [38, 72]],
                ['name' => '西部大区', 'data' => [71, 60]],
            ],
            'xaxis' => ['categories' => ['2024 年', '2025 年']],
            'title' => ['text' => '大区业绩变化趋势', 'align' => 'left'],
            'colors' => ['#5b73e8', '#f46a6a', '#34c38f', '#f1b44c'],
            'stroke' => ['width' => 2],
            'legend' => ['show' => false],
        ];
    }
}
