<?php

namespace App\Http\Requests\SubGroupMenu;

use Illuminate\Foundation\Http\FormRequest;

class SubGroupMenuStoreReq extends FormRequest
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
            'name' => ['required', 'string'],
            'position' => [],
            'description' => [],

            'src' => [],
            'is_src' => ['required', 'string', 'in:0,1'],
            'remove_image' => [],
            'group_menu_id' => ['required'],
            'queue_show'=>['string'],
            'image' => [],
            'status' => ['required', 'string', 'in:0,1'],
        ];
    }
}