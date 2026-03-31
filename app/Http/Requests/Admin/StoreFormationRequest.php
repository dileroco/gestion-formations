<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage formations') ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title_fr' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'short_description_fr' => ['required', 'string'],
            'short_description_en' => ['required', 'string'],
            'description_fr' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'level' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date'],
            'seo_title_fr' => ['nullable', 'string', 'max:255'],
            'seo_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_fr' => ['nullable', 'string'],
            'meta_description_en' => ['nullable', 'string'],
        ];
    }
}
