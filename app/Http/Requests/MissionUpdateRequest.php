<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MissionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'client';
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'adresse' => ['nullable', 'string', 'max:255'],
        ];
    }
}