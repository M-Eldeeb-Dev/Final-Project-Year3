<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : 'NULL';

        return [
            'name'        => ['required', 'string', 'max:255', 'unique:categories,name,'.$categoryId],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ];
    }
}
