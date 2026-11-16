<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Support\JavaScript;

/**
 * 范围条形图 (RangeBar) —— 横向条形表达区间，典型用于甘特图/时间区间。
 *
 * v5 专属：v3 也支持 rangeBar，但这里展示 v5 风格的甘特示例。
 * 数据格式：y 为 [起始, 结束] 区间。
 *
 * @see https://apexcharts.com/docs/chart-types/range-bar-chart/
 */
class RangeBarChart extends AbstractApexChart
{
    public function label(): string
    {
        return '范围条形图 RangeBar (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        // 甘特图：任务在日期区间内的排期（时间戳，单位 ms）
        $day = function (int $d) {
            return strtotime("2025-07-{$d} 00:00:00") * 1000;
        };

        return [
            'chart' => [
                'type'   => 'rangeBar',
                'height' => 350,
            ],
            'plotOptions' => [
                'bar' => ['horizontal' => true],
            ],
            'series' => [
                [
                    'name' => '任务排期',
                    'data' => [
                        ['x' => '需求评审', 'y' => [$day(1), $day(2)]],
                        ['x' => 'UI 设计',  'y' => [$day(2), $day(5)]],
                        ['x' => '前端开发', 'y' => [$day(5), $day(12)]],
                        ['x' => '后端开发', 'y' => [$day(4), $day(14)]],
                        ['x' => '联调测试', 'y' => [$day(12), $day(16)]],
                        ['x' => '上线发布', 'y' => [$day(16), $day(17)]],
                    ],
                ],
            ],
            'title'  => ['text' => '项目排期（甘特图）', 'align' => 'left'],
            'xaxis'  => [
                'type' => 'datetime',
            ],
            'colors' => ['#5b73e8'],
            'dataLabels' => [
                'enabled' => true,
                // formatter 必须是 JS 函数（用 JavaScript::make 注入），否则报 not a function
                'formatter' => JavaScript::make(
                    'function (val, opts) {
                        var s = new Date(val[0]).toLocaleDateString("zh-CN");
                        var e = new Date(val[1]).toLocaleDateString("zh-CN");
                        return s + " ~ " + e;
                    }'
                ),
            ],
        ];
    }
}
