<?php

namespace App\Exceptions;

use Exception;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     */
    public function report(Exception $e)
    {
        if(env('APP_ENV') == 'production' && $this->shouldReport($e)) {
            \Log::error($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof InvalidStateException) {
            return redirect()->route('login')->with('error', 'Please try logging in again');
        }

        if ($e instanceof \Illuminate\Session\TokenMismatchException)
        {
            if($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'CSRF token expired. Please try again.'], 400);
            }

            return redirect()
                ->back()
                ->withInput($request->except('password'))
                ->withErrors(['Validation Token was expired. Please try again']);
        }

        return parent::render($request, $e);
    }
}
