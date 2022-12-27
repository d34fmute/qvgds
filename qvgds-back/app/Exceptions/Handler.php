<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use QVGDS\Exception\QVGDSException;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;

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
    public function register(): void
    {
        $this->renderable(function (QVGDSException $e) {
            return new JsonResponse(["error" => $e->getMessage()], $e->getCode());
        });
        $this->renderable(function (MissingConstructorArgumentsException $e) {
            return new JsonResponse(["error" => "Missing argument: {$e->getMissingConstructorArguments()[0]}"], 400);
        });
    }
}
