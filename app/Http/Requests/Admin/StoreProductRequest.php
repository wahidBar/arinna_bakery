<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')],
            'price' => ['required', 'integer', 'min:0'],
            'discount_price' => ['nullable', 'integer', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'information' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:2048'], // masing-masing gambar maksimal 2MB
            'primary_image_index' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
            'images.required' => 'Minimal unggah 1 gambar produk.',
            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 2MB.',
        ];
    }
}
