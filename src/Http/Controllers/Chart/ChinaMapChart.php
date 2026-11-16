<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Chart;

use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\ChinaMap;

/**
 * 中国地图（ECharts）示例。
 *
 * 演示 Dcat\Admin\Widgets\ChinaMap 组件：全国→省份两级下钻、左侧 legend-panel、
 * 色阶、visualMap。组件自带各省/市级虚拟数据，这里仅覆盖部分参数演示自定义。
 *
 * 独立于 ApexCharts 版本切换（@echarts 资产不随 apexcharts_version 变化）。
 */
class ChinaMapChart
{
    /**
     * 返回 ChinaMap 实例。
     *
     * @return ChinaMap
     */
    public function map(): ChinaMap
    {
        return ChinaMap::make()
            ->title('各省份用户扩展分布')
            ->subtitle('颜色越深表示扩展用户数越多 · 点击省份可查看下钻地图（双击返回）')
            ->height(560)//->showLegend(false)
            ->valueSuffix(' 人');
    }

    /**
     * 带 Box 卡片壳输出（标题标注 ECharts 来源，与 ApexCharts 示例区分）。
     *
     * @return Box
     */
    public function box(): Box
    {
        return Box::make('中国地图 ChinaMap（ECharts）', $this->map())
            ->style('default')
            ->collapsable()
            ->removable();
    }

    public function render(): string
    {
        return (string) $this->map()->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
