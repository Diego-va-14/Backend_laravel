<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Solo interceptar respuestas JSON para rutas API
        if ($request->is('api/*') || $request->expectsJson()) {

            // Modelo no encontrado (findOrFail)
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurso no encontrado.',
                    'data'    => null,
                ], 404);
            }

            // Errores de validación (FormRequest)
            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data'    => null,
                    'errors'  => $e->errors(),
                ], 422);
            }

            // Ruta no encontrada
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ruta no encontrada.',
                    'data'    => null,
                ], 404);
            }

            // Método HTTP no permitido
            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Método HTTP no permitido.',
                    'data'    => null,
                ], 405);
            }

            // Error genérico del servidor
            $message = config('app.debug')
                ? $e->getMessage()
                : 'Error interno del servidor.';

            return response()->json([
                'success' => false,
                'message' => $message,
                'data'    => null,
            ], 500);
        }

        return parent::render($request, $e);
    }
}
