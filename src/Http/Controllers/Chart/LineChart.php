<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 折线图 (Line) —— 多系列、平滑曲线、带数据点标记。
 */
class LineChart extends AbstractApexChart
{
    public function label(): string
    {
        return '折线图 Line';
    }

    public function chartOptions(): array
    {
        return [
            'chart' => [
                'type'   => 'line',
                'height' => 350,
                'zoom'   => ['enabled' => true],
            ],
            'series' => [
                ['name' => '桌面端', 'data' => [30, 40, 35, 50, 49, 60, 70, 91, 125]],
                ['name' => '移动端', 'data' => [23, 12, 54, 61, 32, 56, 81, 70, 109]],
            ],
            'title'   => ['text' => '访问来源趋势', 'align' => 'left'],
            'xaxis'   => [
                'categories' => ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月'],
            ],
            'stroke'  => ['curve' => 'smooth', 'width' => 3],
            'markers' => ['size' => 4],
            'dataLabels' => ['enabled' => false],
            'legend'  => ['position' => 'top'],
            'colors'  => ['#5b73e8', '#f1b44c'],
        ];
    }
}
