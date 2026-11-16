<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * K 线图 (Candlestick) —— 开高低收，金融行情。
 */
class CandlestickChart extends AbstractApexChart
{
    public function label(): string
    {
        return 'K线图 Candlestick';
    }

    public function chartOptions(): array
    {
        // 虚拟 OHLC 数据：[open, high, low, close]
        $days = ['07-01', '07-02', '07-03', '07-04', '07-05', '07-08', '07-09', '07-10', '07-11', '07-12'];
        $data = [
            [82, 85, 78, 84], [84, 88, 82, 86], [86, 87, 80, 81], [81, 84, 78, 83],
            [83, 90, 82, 89], [89, 92, 85, 87], [87, 89, 82, 84], [84, 86, 78, 80],
            [80, 85, 76, 83], [83, 88, 82, 86],
        ];
        $series = [];
        foreach ($days as $i => $day) {
            $series[] = ['x' => $day, 'y' => $data[$i]];
        }

        return [
            'chart' => [
                'type'   => 'candlestick',
                'height' => 350,
            ],
            'series' => [['data' => $series]],
            'title'  => ['text' => '虚拟行情走势', 'align' => 'left'],
            'plotOptions' => [
                'candlestick' => [
                    'colors'   => ['up' => '#34c38f', 'down' => '#f46a6a'],
                    'wick'     => ['useFillColor' => true],
                ],
            ],
            'xaxis'  => ['type' => 'category'],
            'tooltip' => ['enabled' => true],
        ];
    }
}
