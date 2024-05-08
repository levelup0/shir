<?php


namespace App\Actions\Common;


/**
 * Sort passed data by various conditions
 * Class SortData
 * @package App\Actions\Common
 */
class SortData
{
    /**
     * @param $data
     * @param $sort
     */
    public static function execute($data, $sort, $columnName)
    {
        switch ($sort) {
            /**
             * sort by items ascending  id
             */
            case 'id_asc':
                $data = $data->orderBy('id', 'asc');
                break;
            /**
             * sort by ascending items name in choosed column
             */
            case 'name_asc':
                $data = $data->orderBy($columnName, 'asc');
                break;
            /**
             * sort by descending items name in choosed column
             */
            case 'name_desc':
                $data = $data->orderBy($columnName, 'desc');
                break;
            /**
             * sort by ascending items date 
             */
            case 'date_asc':
                $data = $data->orderBy('publish_date', 'asc');
                break;
            /**
             * sort by descenind items date 
             */
            case 'date_desc':
                $data = $data->orderBy('publish_date', 'desc');
                break;
            /**
             * sort by ascending items status
             */
            case 'status_asc':
                $data = $data->orderBy('status', 'asc');
                break;
            /**
             * sort by descenind items status
             */
            case 'status_desc':
                $data = $data->orderBy('status', 'desc');
                break;
            /**
             * default sort
             */
            default:
                $data = $data->orderBy('id', 'desc');
                break;
        }

        /**
         * return sorted data
         */
        return $data;
    }
}