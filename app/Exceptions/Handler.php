<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $role = Auth::check() ? Auth::user()->kode_role : 'umum';
            if (view()->exists("error.404.$role")) {
                return response()->view("error.404.$role", [], 404);
            }

            return response()->view("error.404.umum", [], 404);
        }

        return parent::render($request, $exception);
    }
}
