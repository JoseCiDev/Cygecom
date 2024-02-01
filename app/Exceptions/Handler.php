<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {

            // Verificar se a requisição é uma requisição API
            if ($request->is('api/*') || $request->wantsJson()) {
                // Retornar uma resposta JSON
                return response()->json(['message' => 'Desculpe, você não tem autorização para fazer essa ação.'], 403);
            } else {
                // Se não for uma requisição API, redirecionar ou retornar uma resposta de acordo com sua lógica
                return redirect()->back()->withErrors('Desculpe, você não tem autorização para fazer essa ação.');
            }
        }

        return parent::render($request, $exception);
    }
}
