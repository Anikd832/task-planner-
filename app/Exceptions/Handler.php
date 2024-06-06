<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof NotFoundHttpException) {
                    return respondError("Requested resource not found !", 404);
                } else if ($e instanceof MethodNotAllowedHttpException) {
                    return respondError("Requested method not allowed !", 405);
                } else if ($e instanceof AuthenticationException ) {
                    return respondError("Unauthenticated.", 401);
                }
            } else {
                abort(404);
            }
        });
    }
}
