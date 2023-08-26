<?php

namespace App\Exceptions;

use App\Jobs\WriteErrorLogJob;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->error('Sorry, no data found！', 404);
        }

        // 自定义异常处理逻辑
        if ($exception instanceof CustomException) {
            $message = $exception->getMessage();
            if ($exception->getCode() == CustomException::mysqlError && !Config::get('app.debug')) {
                $message = 'Internal Server Error';
            }

            $data = [
                'error_code' => $exception->getCode(),
                'error_message' => $exception->getMessage(),
            ];
            dispatch(new WriteErrorLogJob($data));
            return response()->error($message, 500);
        }

        return parent::render($request, $exception);
    }
}
