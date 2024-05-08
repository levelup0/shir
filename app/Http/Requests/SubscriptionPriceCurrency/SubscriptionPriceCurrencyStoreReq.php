<?php

namespace App\Http\Requests\SubscriptionPriceCurrency;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPriceCurrencyStoreReq extends FormRequest
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
            'subscription_id' => ['required', 'string'],
            'currency_id' => ['required', 'string'],
            'summ' => ['required', 'string'],
        ];
    }
}