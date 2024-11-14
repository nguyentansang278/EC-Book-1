<?php

namespace App\Http\Requests\Guest\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProcessCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:cod,card',
            'card_number' => 'required_if:payment_method,card',
            'expiry_date' => 'required_if:payment_method,card',
            'cvv' => 'required_if:payment_method,card',
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Enter product quantity',
            'quantity.integer' => 'The number of products must be an integer.',
            'quantity.min' => 'The number of products cannot be less than 1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()->all()
        ], 422));
    }
}
