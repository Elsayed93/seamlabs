<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->apiResponse(null, 'This ' . class_basename($exception->getModel()) . ' Not Found ... ', 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return $this->apiResponse(null, $request->url() . ' Not Found ... ', 404);
            }

            if ($exception instanceof ValidationException) {
                foreach ($exception->errors() as $key => $error) {
                    return $this->apiResponse(null, $error[0], 422);
                }
            }

            return $this->apiResponse(null, $exception->getMessage(), 422);
        }
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->apiResponse(null, $exception->getMessage(), $exception->status);
    }
}
