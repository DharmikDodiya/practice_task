<?php

namespace App\Exceptions;
use Throwable;
use App\Models\Error;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\FlareClient\Http\Exceptions\NotFound;

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
        //AuthorizationException::class,
        //HttpException::class,
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
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
                
                $user_id = 1;
 
                if (Auth::user()) {
                    $user_id = Auth::user()->id;
                }
               
                $data = array(
                    'user_id'   => $user_id,
                    'code'      => $exception->getCode(),
                    'file'      => $exception->getFile(),
                    'line'      => $exception->getLine(),
                    'message'   => $exception->getMessage(),
                    'trace'     => $exception->getTraceAsString(),
                );
               
                Error::create($data);

                if($exception instanceof AuthenticationException)
                {
                    return error("not access this page without Login!!!",type:'unauthenticated');
                }
                else if($exception instanceof RouteNotFoundException)
                {
                    return error("not access this page without Login!!!",type:'notfound');
                }
        });
 
    }
}
