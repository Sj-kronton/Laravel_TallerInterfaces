<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $plato = $this->route('plato');

        return [
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('platos', 'nombre')->ignore($plato),
            ],
            'precio' => ['required', 'numeric', 'min:1000'],
            'descripcion' => ['required', 'string', 'min:10'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
