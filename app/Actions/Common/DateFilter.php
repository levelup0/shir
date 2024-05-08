<?php


namespace App\Actions\Common;

/**
 * Filter data by request date;
 * Class DateFilter
 * @package App\Actions\Common
 */
class DateFilter
{
    /**
     * @param $data
     * @param $date
     */
    public static function execute($data, $date)
    {
        $startDate = $date[0];
        $endDate = $date[1];

        $data = $data->whereBetween('publish_date', [$startDate, $endDate]);

        return $data;
    }
}