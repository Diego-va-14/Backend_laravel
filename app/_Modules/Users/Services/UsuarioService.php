<?php

namespace App\_Modules\Users\Services;

use App\Models\Usuario;

class UsuarioService
{
    public function getAll()
    {
        return Usuario::all();
    }

    public function findById($id)
    {
        return Usuario::findOrFail($id);
    }

    public function create(array $data)
    {
        return Usuario::create($data);
    }

    public function update($id, array $data)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($data);
        return $usuario;
    }

    public function delete($id)
    {
        return Usuario::findOrFail($id)->delete();
    }
}
