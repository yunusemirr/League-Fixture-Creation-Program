<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
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
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            switch (get_class($e)) {
                case UnauthorizedException::class:
                    return BaseController::response(false, [], 'Yetkisiz İşlem', 401);
                    break;
                case AuthenticationException::class:
                case ExceptionsAuthenticationException::class:
                    return BaseController::response(false, [], 'Yetkisiz İşlem', 401);
                    break;
                case NotFoundHttpException::class:
                case ModelNotFoundException::class:
                    return BaseController::response(false, [], 'Sayfa Bulunamadı', 404);
                    break;
                case ValidationException::class:
                    return BaseController::response(false, [], $e->validator->errors()->first(), 422);
                    break;
                default:
                    return app()->environment() == 'local' ? parent::render($request, $e) :  BaseController::response(false, [], $e->getMessage(), 200);
                    break;
            }
        }
        return parent::render($request, $e);
    }
}
