<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedException) {
            return response()->view("errors.forbidden", [
                "exception" => $e
            ], 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->view("errors.not-found", [
                "exception" => $e
            ], 404);
        }

        $exception = FlattenException::create($e);
        $statusCode = $exception->getStatusCode($exception);

        if ($statusCode === 500) {
            return response()->view("errors.internal", [
                "exception" => $e
            ], 500);
        }

        return parent::render($request, $e);
    }
}
