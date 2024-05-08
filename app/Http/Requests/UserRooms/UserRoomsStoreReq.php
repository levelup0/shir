<?php

namespace App\Http\Requests\UserRooms;

use Illuminate\Foundation\Http\FormRequest;

class UserRoomsStoreReq extends FormRequest
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
            'user_id' => [],
            'operator_id' => [],
            'status_message' => ['required', 'string'],
            'user_chat_id' => ['required', 'string'],
        ];
    }
}