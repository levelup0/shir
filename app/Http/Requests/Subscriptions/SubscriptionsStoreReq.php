<?php

namespace App\Http\Requests\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionsStoreReq extends FormRequest
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
            'price' => ['required', 'string'],
            'description'=>[],
            'remove_image' => [],
            'image' => [],
            //'image' => ['required', 'image', 'mimes:jpeg,jpg,png', "dimensions:max_width=2048, max_height=2048", 'max:2048'],
            'status' => ['required', 'string', 'in:0,1'],
            'queue_show' => [],
        ];
    }
}