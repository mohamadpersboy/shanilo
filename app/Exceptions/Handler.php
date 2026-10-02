<?php

namespace App\Exceptions;

use App\Models\Specific\Cart;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Session;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        if($request->hasCookie('language')) {
//            // Get cookie
//            $cookie = $request->cookie('language');
//            // Check if cookie is already decrypted if not decrypt
//            $cookie = strlen($cookie) > 2 ? decrypt($cookie) : $cookie;
//            // Set locale
//            app()->setLocale($cookie);
//        }
//
//        if($exception instanceof NotFoundHttpException) {
//            return response()->view('errors.404', [
//                'breadcrumbs'=>[
//                    'active'=>'خطای 404'
//                ]
//            ], 404);
//        }elseif($exception instanceof FatalThrowableError && env('APP_ENV')=='production'){
////            return response()->view('errors.500', [
////                'breadcrumbs'=>[
////                    'active'=>'خطای سیستم'
////                ]
////            ], 500);
//        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
