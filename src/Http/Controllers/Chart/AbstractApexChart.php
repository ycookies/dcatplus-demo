<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Widgets\ApexCharts\Chart;
use Dcat\Admin\Widgets\Box;

/**
 * ApexCharts v5.16.0 示例图表基类。
 *
 * 子类只需实现 chartOptions() 返回 ApexCharts 的 options 数组；
 * label() 返回中文名称，用于卡片标题与 Tab 标题。
 *
 * 通过 box() / chart() 两种方式输出，前者带卡片壳，后者纯图表。
 */
abstract class AbstractApexChart
{
    /**
     * 图表中文名称（同时用作卡片标题）。
     *
     * @return string
     */
    abstract public function label(): string;

    /**
     * ApexCharts options 数组。
     *
     * @return array
     */
    abstract public function chartOptions(): array;

    /**
     * 构造 Chart Widget。
     *
     * @return Chart
     */
    public function chart(): Chart
    {
        return Chart::make($this->chartOptions());
    }

    /**
     * 带 Box 卡片壳输出，便于在页面中按栅格摆放。
     *
     * @param  string  $style Box 样式 (default/primary/success/...)
     * @return Box
     */
    public function box(string $style = 'default'): Box
    {
        $box = Box::make($this->label(), $this->chart())
            ->style($style)
            ->collapsable()
            ->removable();

        // v5 专属图表在卡片标题后加标记，便于识别
        if ($this->isV5Only()) {
            $box->tools('<span class="badge" style="background:#5b73e8">v5</span>');
        }

        return $box;
    }

    /**
     * 是否为 ApexCharts v5 专属图表类型（v3 不支持）。
     * 子类按需覆写为 true。
     *
     * @return bool
     */
    public function isV5Only(): bool
    {
        return false;
    }

    /**
     * 直接渲染（__toString 时返回 chart 的 html）。
     *
     * @return string
     */
    public function render(): string
    {
        return (string) $this->chart()->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
