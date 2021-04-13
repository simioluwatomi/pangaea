<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use ReflectionClass;
use Throwable;

trait ExceptionHandlerTrait
{
    /**
     * Returns JSON response for model not found exception.
     *
     * @param Throwable $exception
     *
     * @throws \ReflectionException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound(Throwable $exception)
    {
        /** @var ModelNotFoundException $exception */
        $model = new ReflectionClass($exception->getModel());

        return $this->respondWithError(
            $model->getShortName().' not found.',
            404
        );
    }

    /**
     * Returns JSON response for Eloquent model not found exception.
     *
     * @param Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function httpClientError(Throwable $exception)
    {
        return $this->respondWithError(
            "{$exception->getMessage()}",
            $exception->getCode()
        );
    }

    /**
     * Returns JSON response for Eloquent model not found exception.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function routeNotFound()
    {
        return $this->respondWithError(
            'The requested URI is invalid.',
            404
        );
    }

    protected function authorizationError(Throwable $exception)
    {
        return $this->respondWithError(
            $exception->getMessage(),
            403
        );
    }

    protected function unauthenticatedError(Throwable $exception)
    {
        return $this->respondWithError(
            $exception->getMessage(),
            401
        );
    }

    /**
     * Returns json response error.
     *
     * @param       $message
     * @param mixed $statusCode
     * @param mixed $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message, $statusCode, $headers = [])
    {
        return response()->json([
            'status'      => 'fail',
            'status_code' => $statusCode,
            'error'       => [
                'message' => $message,
            ],
        ], $statusCode, $headers);
    }
}
