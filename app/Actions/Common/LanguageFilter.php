<?php


namespace App\Actions\Common;

use App\Models\Language;

/**
 * Filter data by request language;
 * Class LanguageFilter
 * @package App\Actions\Common
 */
class LanguageFilter
{
    /**
     * @param $data
     * @param $languages
     */
    public static function execute($data, $languages)
    {
        $array_language_filter = [];

        foreach ($languages as $language) {
            $array_language_filter[] = $language['id'];
        }

        $data = $data->whereIn('language_id', $array_language_filter);

        return $data;
    }

    public static function executeNew($data, $languages)
    {
        $id = Language::where('name', $languages)->first()->id;

        $data = $data->where('language_id', $id);

        return $data;
    }
}