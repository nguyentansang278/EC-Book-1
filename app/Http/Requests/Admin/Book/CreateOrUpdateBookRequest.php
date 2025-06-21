<?php
namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateBookRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'author_id' => 'nullable|exists:authors,id',
            'new_author' => 'nullable|string|max:255',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string',
            'cover_img' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ];
    }
}
