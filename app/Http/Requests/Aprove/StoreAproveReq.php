<?php

namespace App\Http\Requests\Aprove;

use Illuminate\Foundation\Http\FormRequest;

class StoreAproveReq extends FormRequest
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
            'voz_id' => ['required'],
            'user_id' => ['required'],
            'status' => [],
        ];
    }
}