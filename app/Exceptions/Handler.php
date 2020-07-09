<?php

namespace App\Exceptions;

use Throwable;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Intervention\Image\Exception\NotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException)
            return redirect()->route('login')->with(['message' => 'توکن شما مسدود شده است.' ]);

        if ( $exception instanceof NotFoundHttpException )
            return response()->view("errors.404" , [
                "p_title" => trans('dashboard.errors.404.text')
            ] , 200);

        return parent::render($request, $exception);
    }
}
