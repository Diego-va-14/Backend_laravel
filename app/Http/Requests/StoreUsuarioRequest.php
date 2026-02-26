<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|unique:usuarios',
            'rol'    => 'required|in:admin,user',
            'estado' => 'required|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string'   => 'El nombre debe ser una cadena de texto.',
            'nombre.max'      => 'El nombre no puede exceder los 100 caracteres.',
            'email.required'  => 'El correo electrónico es obligatorio.',
            'email.email'     => 'El correo electrónico no tiene un formato válido.',
            'email.unique'    => 'Este correo electrónico ya está registrado.',
            'rol.required'    => 'El rol es obligatorio.',
            'rol.in'          => 'El rol debe ser "admin" o "user".',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in'       => 'El estado debe ser "activo" o "inactivo".',
        ];
    }
}
