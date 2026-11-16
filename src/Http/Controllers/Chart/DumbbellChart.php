<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 哑铃图 (Dumbbell) —— 对比各类别在两个时间点的差值（"哑铃"两端）。
 *
 * v5 专属：v3 不支持。
 * 实现方式：chart.type=bar + plotOptions.bar.isDumbbell=true
 * 数据格式：y 为 [起始值, 结束值]。
 */
class DumbbellChart extends AbstractApexChart
{
    public function label(): string
    {
        return '哑铃图 Dumbbell (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    public function chartOptions(): array
    {
        $items = [
            ['研发部', 45, 78],
            ['产品部', 50, 66],
            ['市场部', 60, 52],
            ['运营部', 38, 70],
            ['设计部', 55, 62],
        ];
        $data = [];
        foreach ($items as [$name, $a, $b]) {
            $data[] = ['x' => $name, 'y' => [$a, $b]];
        }

        return [
            'chart' => [
                'type'    => 'bar',
                'height'  => 350,
                'toolbar' => ['show' => true],
            ],
            'plotOptions' => [
                'bar' => [
                    'isDumbbell'    => true,
                    'dumbbellColors'=> ['#5b73e8', '#34c38f'],
                    'columnWidth'   => '70%',
                ],
            ],
            'series' => [
                ['name' => '年初 vs 年末', 'data' => $data],
            ],
            'title'  => ['text' => '部门绩效：年初 vs 年末', 'align' => 'left'],
            'legend' => ['show' => false],
            'dataLabels' => ['enabled' => false],
        ];
    }
}
