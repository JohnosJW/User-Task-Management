<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $data
     * @param int $responseCode
     * @return JsonResponse
     */
    protected function successResponse(array $data = [], $responseCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $responseCode);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(array $data = [], $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }
}
