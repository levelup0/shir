<?php

namespace App\Http\Requests\SubscriptionMonth;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionMonthUpdateReq extends FormRequest
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
        $createRules = (new SubscriptionMonthStoreReq())->rules();
        return $this->editValidationRules($createRules);
    }
}
