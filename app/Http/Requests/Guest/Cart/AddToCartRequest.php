<?php

namespace App\Http\Requests\Guest\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'book_id' => 'required|exists:books,id',
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
