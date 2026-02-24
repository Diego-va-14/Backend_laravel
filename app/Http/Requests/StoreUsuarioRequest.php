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
}
