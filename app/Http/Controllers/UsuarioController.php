<?php

namespace App\Http\Controllers;

use App\_Core\Traits\ApiResponse;
use App\_Modules\Users\Services\UsuarioService;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

class UsuarioController extends Controller
{
    use ApiResponse;

    public function __construct(private UsuarioService $service) {}

    public function index()
    {
        $usuarios = $this->service->getAll();
        return $this->success($usuarios, 'Lista de usuarios');
    }

    public function show($id)
    {
        $usuario = $this->service->findById($id);
        return $this->success($usuario, 'Usuario encontrado');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $usuario = $this->service->create($request->validated());
        return $this->success($usuario, 'Usuario creado', 201);
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = $this->service->update($id, $request->validated());
        return $this->success($usuario, 'Usuario actualizado');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->success(null, 'Usuario eliminado');
    }
}
