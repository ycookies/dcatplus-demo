<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\Repository;
use Faker\Factory;

class Report extends Repository
{
    public function get(Grid\Model $model)
    {
        $items = $this->fetch();

        return $model->makePaginator(
            1000,
            $items
        );
    }

    /**
     * 这里生成假数据演示报表功能
     *
     * @return array
     */
    public function fetch()
    {
        $faker = Factory::create();

        $data = [];

        $room_name = [
            '大床房',
            '大床房',
            '大床房',
            '1床房',
            '1床房',
            '2床房',
            '2床房',
            '3床房',
            '3床房',
            '3床房',
            '4床房',
            '4床房',
            '4床房',
            '5床房',
            '5床房',
            '5床房',
            '6床房',
            '6床房',
        ];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'id' => $i + 1,
                'name' => $faker->name,
                'content' => $faker->text,
                'room_name' => !empty($room_name[$i]) ? $room_name[$i]:'二人房',
                'cost' => $faker->randomFloat(),
                'avgMonthCost' => $faker->randomFloat(),
                'avgQuarterCost' => $faker->randomFloat(),
                'avgYearCost' => $faker->randomFloat(),
                'incrs' => $faker->numberBetween(1, 999999999),
                'avgMonthVist' => $faker->numberBetween(1, 999999),
                'avgQuarterVist' => $faker->numberBetween(1, 999999),
                'avgYearVist' => $faker->numberBetween(1, 999999),
                'avgVists' => $faker->numberBetween(1, 999999),
                'topCost' => $faker->numberBetween(1, 999999999),
                'topVist' => $faker->numberBetween(1, 9999990009),
                'topIncr' => $faker->numberBetween(1, 99999999),
                'date' => $faker->date(),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ];
        }

        return $data;
    }
}
