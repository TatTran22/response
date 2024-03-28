<?php

namespace TatTran\Response;

use Illuminate\Http\JsonResponse;
use TatTran\Response\Transformers\ResponseTransformer;

trait ResponseHandler
{
    public $transform;

    /**
     * @param $transform
     * @return void
     */
    protected function setTransformer($transform)
    {
        $this->transform = $transform;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    protected function successResponse($data)
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => $this->transform ? $this->transform($data) : ($data ?? [])
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * @return JsonResponse
     */
    protected function notFoundResponse()
    {
        return response()->json([
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * @return JsonResponse
     */
    public function deleteResponse()
    {
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource Deleted'
        ], 200);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function errorResponse($data)
    {
        return response()->json([
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable Entity'
        ], 422);
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    public function paymentRequiredResponse($message)
    {
        return response()->json([
            'code' => 402,
            'status' => 'error',
            'data' => 'payment required',
            'message' => $message
        ], 402);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function transform($data)
    {
        return app()->make(ResponseTransformer::class)->transform($data, $this->transform);
    }
}
