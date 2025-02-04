<?php

namespace App\Http\Requests\Guest\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,card',
            'stripeToken' => 'required_if:payment_method,card',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
