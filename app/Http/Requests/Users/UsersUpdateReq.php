<?php

namespace App\Http\Requests\Users;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateReq extends FormRequest
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
        $createRules = (new UsersStoreReq())->rules();
        return $this->editValidationRules($createRules);
    }
}
