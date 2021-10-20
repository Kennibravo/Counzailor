<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use App\Traits\HasApiResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TypeError;

class Handler extends ExceptionHandler
{
    use HasApiResponse;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        /*AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,*/
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundAlert("We cannot access the resource you are looking for", 'resource_not_found');
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFoundAlert("Unable to locate model resource", 'model_not_found');
        }

        if ($exception instanceof HttpException) {
            return $this->httpErrorAlert($exception->getMessage(), $exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->formValidationErrorAlert($exception->errors());
        }

        if($exception instanceof QueryException){
            return $this->serverErrorAlert("Something went wrong while querying the database", $exception);
        }

        if($exception instanceof TypeError){
            return $this->badRequestAlert($exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
