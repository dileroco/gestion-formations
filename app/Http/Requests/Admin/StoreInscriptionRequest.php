<?php

namespace App\Http\Requests\Admin;

use App\Enums\InscriptionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreInscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage inscriptions');
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'training_session_id' => ['required', 'exists:training_sessions,id'],
            'status' => ['required', new Enum(InscriptionStatus::class)],
            'grade' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
