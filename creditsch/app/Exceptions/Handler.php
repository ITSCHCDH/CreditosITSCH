<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
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

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                return response()->view('exceptiones.error_403',[],403);
        }
        if($exception instanceof \Symfony\Component\HttpFoundation\File\Exception\FileException){
            $upload_max_filesize = (int)ini_get('upload_max_filesize');
            Flash::error('Favor de no subir archivos con un peso mayor a '.$upload_max_filesize.' Mb');
            return redirect()->back();
        }
        if($exception instanceof PostTooLargeException){
            $post_max_size = (int)ini_get('post_max_size');
            Flash::error('Verificar que la suma del peso de los archivos no exceda los '.$post_max_size.' Mb');
            return redirect()->back();
        }

        if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
            if(!Auth::Guard('web')->check() && !Auth::Guard('alumno')->check()){
                return redirect('/');
            }
        }
        return parent::render($request, $exception);
    }

}
