<?php

namespace App\Http\Requests\UpdateAdminPassword;

 
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPasswordReq extends FormRequest
{
    use ValidationTrait;
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
            'new_password' => ['required', 'string', 'max:255'],
        ];
    }
}
