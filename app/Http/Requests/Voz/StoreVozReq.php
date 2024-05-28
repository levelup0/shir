<?php

namespace App\Http\Requests\Voz;

use Illuminate\Foundation\Http\FormRequest;

class StoreVozReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            // 'sector' => ['required'],
            'description' => ['required'],
            'publish_date' => ['required'],
            'end_date' => ['required'],
            'category_voz_id' => [],
            'user_id' => [],
            'status' => [],
            'voz_category_relation' => [],
            'files' => [],
        ];
    }
}