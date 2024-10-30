<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'current_password'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'password.required' => 'Password is required.',
            'password.current_password' => 'The password is incorrect.',
        ];
    }
}
