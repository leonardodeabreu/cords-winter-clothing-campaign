<?php

namespace App\Exceptions;

use App\Base\Enums\ResponseEnum;
use App\Base\Exceptions\BaseException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport
        = [

        ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash
        = [
            'password',
            'password_confirmation',
        ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception): void
    {
        if ($exception instanceof UnauthorizedException) {
            abort($exception->getStatusCode(), trans(ResponseEnum::IS_NOT_ALLOWED));
        }
        if ($exception instanceof HttpException) {
            Log::error(
                "Handle Report\n
                - Trace: {$exception->getTraceAsString()}\n
                - Code: {$exception->getStatusCode()}\n
                - Message: {$exception->getMessage()}\n"
            );
            if (!in_array(intval($exception->getStatusCode()), array_keys(Response::$statusTexts))) {
                abort(500, Response::$statusTexts[500]);
            }
        }

        if ($exception instanceof BaseException) {
            report($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
