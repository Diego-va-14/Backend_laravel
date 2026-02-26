<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:100',
            'email'  => 'sometimes|email|unique:usuarios,email,' . $this->route('id'),
            'rol'    => 'sometimes|in:admin,user',
            'estado' => 'sometimes|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string'  => 'El nombre debe ser una cadena de texto.',
            'nombre.max'     => 'El nombre no puede exceder los 100 caracteres.',
            'email.email'    => 'El correo electrónico no tiene un formato válido.',
            'email.unique'   => 'Este correo electrónico ya está registrado.',
            'rol.in'         => 'El rol debe ser "admin" o "user".',
            'estado.in'      => 'El estado debe ser "activo" o "inactivo".',
        ];
    }
}
