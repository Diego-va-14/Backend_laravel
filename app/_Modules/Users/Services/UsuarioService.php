<?php

namespace App\_Modules\Users\Services;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioService
{
    public function getAll(Request $request)
    {
        $query = Usuario::query();

        // Búsqueda por nombre o email
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($rol = $request->query('rol')) {
            $query->where('rol', $rol);
        }

        // Filtro por estado
        if ($estado = $request->query('estado')) {
            $query->where('estado', $estado);
        }

        // Ordenamiento por defecto: más recientes primero
        $query->orderBy('id', 'desc');

        // Paginación (solo si se envía ?page=)
        if ($request->has('page')) {
            $perPage = $request->query('per_page', 15);
            return $query->paginate($perPage);
        }

        // Sin paginación: retorna todos (compatibilidad con frontend actual)
        return $query->get();
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
