<?php

namespace App\Http\Requests\Admin;

use App\Enums\InscriptionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateInscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage inscriptions');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(InscriptionStatus::class)],
            'grade' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
