<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage sessions') ?? false;
    }

    public function rules(): array
    {
        return [
            'formation_id' => ['required', 'exists:formations,id'],
            'trainer_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'capacity' => ['required', 'integer', 'min:1'],
            'mode' => ['required', 'in:presentiel,online,hybride'],
            'city' => ['nullable', 'string', 'max:255'],
            'meeting_link' => ['nullable', 'url'],
            'status' => ['required', 'in:upcoming,ongoing,finished'],
        ];
    }
}
