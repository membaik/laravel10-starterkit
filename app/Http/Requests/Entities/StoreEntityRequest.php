<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            "status" => "nullable|boolean",
            'entity_categories' => 'nullable|array',
            'entity_categories.*' => 'nullable|string|exists:App\Models\EntityCategory,id',
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'is_active' => $this->boolean('status'),
            'entity_categories' => $this->input('entity_categories'),
        ];
    }
}
