<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('platos', 'nombre')->whereNull('deleted_at'),
            ],
            'precio' => ['required', 'numeric', 'min:1000'],
            'descripcion' => ['required', 'string', 'min:10'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del plato es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede superar los :max caracteres.',
            'nombre.unique' => 'Ya existe un plato con ese nombre.',

            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio mínimo es de $1.000.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres.',

            'imagen.required' => 'Debes seleccionar una imagen.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser formato jpg, png o webp.',
            'imagen.max' => 'La imagen no puede superar los 2 MB.',
        ];
    }
}