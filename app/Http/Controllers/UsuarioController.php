<?php

namespace App\Http\Controllers;

use App\_Core\Traits\ApiResponse;
use App\_Modules\Users\Services\UsuarioService;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UsuarioController extends Controller
{
    use ApiResponse;

    public function __construct(private UsuarioService $service) {}

    public function index(Request $request)
    {
        try {
            $result = $this->service->getAll($request);

            if ($result instanceof LengthAwarePaginator) {
                return $this->paginatedSuccess($result, 'Lista de usuarios');
            }

            return $this->success($result, 'Lista de usuarios');
        } catch (\Exception $e) {
            return $this->error('Error al obtener la lista de usuarios.', 500);
        }
    }

    public function show($id)
    {
        try {
            $usuario = $this->service->findById($id);
            return $this->success($usuario, 'Usuario encontrado');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Usuario no encontrado.', 404);
        } catch (\Exception $e) {
            return $this->error('Error al buscar el usuario.', 500);
        }
    }

    public function store(StoreUsuarioRequest $request)
    {
        try {
            $usuario = $this->service->create($request->validated());
            return $this->success($usuario, 'Usuario creado exitosamente', 201);
        } catch (\Exception $e) {
            return $this->error('Error al crear el usuario.', 500);
        }
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        try {
            $usuario = $this->service->update($id, $request->validated());
            return $this->success($usuario, 'Usuario actualizado exitosamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Usuario no encontrado.', 404);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar el usuario.', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return $this->success(null, 'Usuario eliminado exitosamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Usuario no encontrado.', 404);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar el usuario.', 500);
        }
    }
}
