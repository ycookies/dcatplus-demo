<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

/**
 * 小提琴图 (Violin) —— 箱线图 + 核密度分布，表达数据集中趋势与离散。
 *
 * v5 专属：v3 不支持。
 *
 * 数据格式（关键）：每个数据点的 y 必须是对象
 *   { density: [[value, weight], ...], points?: [观测值...] }
 * density 是预计算的密度曲线（value 对应轴值，weight 对应密度权重）。
 * points 是原始观测点（可选，渲染为 jitter 抖点）。
 */
class ViolinChart extends AbstractApexChart
{
    public function label(): string
    {
        return '小提琴图 Violin (v5)';
    }

    public function isV5Only(): bool
    {
        return true;
    }

    /**
     * 生成正态分布的虚拟密度数据 + 观测点。
     *
     * @param  float  $mean   均值
     * @param  float  $sigma  标准差
     * @return array{0: array, 1: array}  [density, points]
     */
    protected function normalDensity(float $mean, float $sigma): array
    {
        $density = [];
        $points  = [];
        $min = $mean - 4 * $sigma;
        $max = $mean + 4 * $sigma;
        $step = ($max - $min) / 40;

        for ($x = $min; $x <= $max; $x += $step) {
            // 正态分布概率密度
            $w = exp(-0.5 * pow(($x - $mean) / $sigma, 2)) / ($sigma * sqrt(2 * M_PI));
            $density[] = [round($x, 2), round($w, 4)];
        }
        // 生成 ~30 个观测点
        for ($i = 0; $i < 30; $i++) {
            // Box-Muller 近似：均值 ± 噪声
            $u = (mt_rand() / mt_getrandmax());
            $v = (mt_rand() / mt_getrandmax());
            $z = sqrt(-2 * log($u ?: 0.0001)) * cos(2 * M_PI * $v);
            $points[] = round($mean + $z * $sigma, 2);
        }

        return [$density, $points];
    }

    public function chartOptions(): array
    {
        [$aD, $aP] = $this->normalDensity(60, 12);
        [$bD, $bP] = $this->normalDensity(78, 8);
        [$cD, $cP] = $this->normalDensity(48, 16);

        return [
            'chart' => [
                'type'   => 'violin',
                'height' => 350,
            ],
            'series' => [
                ['name' => 'A 班', 'data' => [['x' => 'A 班', 'y' => ['density' => $aD, 'points' => $aP]]]],
                ['name' => 'B 班', 'data' => [['x' => 'B 班', 'y' => ['density' => $bD, 'points' => $bP]]]],
                ['name' => 'C 班', 'data' => [['x' => 'C 班', 'y' => ['density' => $cD, 'points' => $cP]]]],
            ],
            'title'  => ['text' => '班级成绩分布', 'align' => 'left'],
            'plotOptions' => [
                'violin' => [
                    'normalize'     => 'individual',
                    'bandwidthScale' => 1.0,
                    'points' => [
                        'show'   => true,
                        'size'   => 3,
                        'jitter' => 0.5,
                    ],
                ],
            ],
            'colors' => ['#5b73e8', '#34c38f', '#f1b44c'],
            'stroke' => ['width' => 1, 'colors' => ['#fff']],
            'fill'   => ['opacity' => 0.7],
            'dataLabels' => ['enabled' => false],
            'tooltip' => ['shared' => true],
        ];
    }
}
