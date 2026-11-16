<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Support\JavaScript;

/**
 * 漏斗图 (Funnel) —— 转化漏斗，各阶段递减。
 *
 * v5 专属：v3 不支持。
 *
 * 注意：dataLabels.formatter / tooltip.formatter 必须是 JS 函数，
 * 不能写字符串字面量（如 'PERCENT'），否则报 "formatter is not a function"。
 * 这里用 Dcat\Admin\Support\JavaScript::make() 注入真实 JS 代码。
 */
class FunnelChart extends AbstractApexChart
{
    public function label(): string
    {
        return '漏斗图 Funnel (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'funnel',
                'height' => 350,
            ],
            'series' => [
                [
                    'name' => '转化',
                    'data' => [
                        ['x' => '访问', 'y' => 10000],
                        ['x' => '加购', 'y' => 5800],
                        ['x' => '下单', 'y' => 3200],
                        ['x' => '支付', 'y' => 2100],
                        ['x' => '复购', 'y' => 960],
                    ],
                ],
            ],
            'title'  => ['text' => '用户转化漏斗', 'align' => 'left'],
            'plotOptions' => [
                'funnel' => [
                    'shape'      => 'funnel',   // 或 'rectangle'
                    'borderRadius' => 4,
                ],
            ],
            'colors' => ['#5b73e8', '#50a5f1', '#34c38f', '#f1b44c', '#f46a6a'],
            'dataLabels' => [
                'enabled'   => true,
                // 用 JS 函数显示：阶段名 + 绝对值 + 占首阶段百分比
                'formatter' => JavaScript::make(
                    "function (val, opts) {
                        var first = opts.w.config.series[opts.seriesIndex].data[0].y || 1;
                        var pct = (val / first * 100).toFixed(1);
                        return opts.w.globals.labels[opts.dataPointIndex]
                            + ': ' + val + ' (' + pct + '%)';
                    }"
                ),
                'dropShadow' => ['enabled' => false],
            ],
            'legend' => ['show' => false],
        ];
    }
}
