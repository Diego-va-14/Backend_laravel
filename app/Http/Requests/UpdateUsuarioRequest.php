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
            'email'  => 'sometimes|email|unique:usuarios,email,' . $this->route('usuario'),
            'rol'    => 'sometimes|in:admin,user',
            'estado' => 'sometimes|in:activo,inactivo',
        ];
    }
}
