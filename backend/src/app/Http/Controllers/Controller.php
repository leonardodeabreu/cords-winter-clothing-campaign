<?php

namespace App\Http\Controllers;

use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    protected $repository;

    /**
     * @param int $id
     *
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            if ($this->repository->delete($id)) {
                return $this->response->noContent();
            }
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param string   $message
     * @param int|null $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseMessage(string $message, ?int $code = 200): JsonResponse
    {
        return response()->json([
            'message'     => trans($message),
            'status_code' => $code
        ], $code);
    }

    /**
     * @param array    $data
     * @param int|null $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseData(array $data, ?int $code = 200): JsonResponse
    {
        return response()->json([
            'data'        => $data,
            'status_code' => $code
        ], $code);
    }
}
