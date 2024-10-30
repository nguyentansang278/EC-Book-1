<?php

namespace App\Http\Requests\Robot;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\RobotServices;

class CreateRobotRequest extends FormRequest
{
    public function __construct()
    {
        $this->robotServices = new RobotServices;
    }

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
            // 'robot_name' => ['required', 'string', 'max:255', 'unique:robots,database_name'],
            // 'table_name' => ['required', 'string', 'max:255'],
            'fee' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
    public function messages(): array
    {
        return [
            // 'robot_name.required' => 'Robot name is required.',
            // 'table_name.required' => 'Table name is required.',
            'fee.required' => 'Fee is required.',
        ];
    }
}
