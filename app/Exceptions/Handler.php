<?php

namespace App\Exceptions;

use App\Models\ErrorLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * Report or log an exception.
     */
    public function report(Throwable $exception): void
    {
        ErrorLog::create([

            'error_message' => $exception->getMessage(),
            'line_number' => $exception->getLine(),
            'function_name' => __FUNCTION__,
            'file_name' => $exception->getFile(),
        ]);
    }

    /**
     * Render an exception into an HTTP response.
     */
    // public function render($request, Throwable $exception)
    // {
    //     ErrorLog::create([

    //         'error_message' => $exception->getMessage(),
    //         'line_number' => $exception->getLine(),
    //         'function_name' => $exception->__FUNCTION__,
    //         'file_name' => $exception->getFile(),
    //     ]);
    //  return response()->json([
    //     'error' => $exception->getMessage()
    //  ], 500);
    // }
}
