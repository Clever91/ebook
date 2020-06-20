<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            if ($exception instanceof NotFoundHttpException) {

                $response = [
                    'success' => false,
                    'data' => ['error' => 'Url is not found'],
                    'message' => 'Page is not found'
                ];
        
                return response()->json($response, 404);
            }

            if ($exception instanceof ModelNotFoundException) {

                $response = [
                    'success' => false,
                    'data' => ['error' => 'Model is not found'],
                    'message' => 'Model is not found'
                ];
        
                return response()->json($response, 404);
            }

            if (!env('APP_DEBUG')) {
                $response = [
                    'success' => false,
                    'data' => ['error' => 'Server Error'],
                    'message' => $exception->getMessage()
                ];  
                  
                return response()->json($response, 500);
            }
        }

        if ($this->isHttpException($exception)) {

            if ($exception->getStatusCode() == 404) {
                // return response()->view('error._404', [], 4040);
                return redirect()->route('error404');
            }
            
            if ($exception->getStatusCode() == 500) {
                // return response()->view('error._500', [], 500);
                return redirect()->route('error500');
            }
        }

        return parent::render($request, $exception);
    }
}
