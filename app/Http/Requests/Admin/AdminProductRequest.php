<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : 'NULL';

        $rules = [
            'category_id'       => ['required', 'exists:categories,id'],
            'name'              => ['required', 'string', 'max:255', 'unique:products,name,'.$productId],
            'sku'               => ['nullable', 'string', 'max:100', 'unique:products,sku,'.$productId],
            'description'       => ['required', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price'             => ['required', 'numeric', 'min:0'],
            'sale_price'        => ['nullable', 'numeric', 'min:0'],
            'image'             => ['nullable', 'image', 'max:2048'],
            'stock'             => ['required', 'integer', 'min:0'],
            'size_options'      => ['nullable', 'string'],
            'color_options'     => ['nullable', 'string'],
            'is_featured'       => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],
        ];

        // Only validate sale_price < price when both present
        if ($this->filled('price') && $this->filled('sale_price')) {
            $rules['sale_price'][] = 'lt:price';
        }

        return $rules;
    }
}
