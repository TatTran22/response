<?php

namespace TatTran\Response;

use TatTran\Response\Transformers\ResponseTransformer;
use Illuminate\Http\JsonResponse;

trait ResponseHandler
{
    /**
     * Transform instance.
     *
     * @var mixed
     */
    protected $transform;

    /**
     * Set transformer for response.
     *
     * @param mixed $transform
     * @return void
     */
    protected function setTransformer($transform)
    {
        $this->transform = $transform;
    }

    /**
     * Generate success response.
     *
     * @param mixed|null $data
     * @return JsonResponse
     */
    protected function successResponse($data = null): JsonResponse
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => $data ?? [],
        ];

        return $this->generateResponse($response, $response['code']);
    }

    /**
     * Generate not found response.
     *
     * @return JsonResponse
     */
    protected function notFoundResponse(): JsonResponse
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found',
        ];

        return $this->generateResponse($response, $response['code']);
    }

    /**
     * Generate delete response.
     *
     * @return JsonResponse
     */
    public function deleteResponse(): JsonResponse
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource Deleted',
        ];

        return $this->generateResponse($response, $response['code']);
    }

    /**
     * Generate error response.
     *
     * @param mixed $data
     * @return JsonResponse
     */
    public function errorResponse($data): JsonResponse
    {
        $response = [
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable Entity',
        ];

        return $this->generateResponse($response, $response['code']);
    }

    /**
     * Generate payment required response.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function paymentRequiredResponse(string $message): JsonResponse
    {
        $response = [
            'code' => 402,
            'status' => 'error',
            'data' => 'payment required',
            'message' => $message,
        ];

        return $this->generateResponse($response, $response['code']);
    }

    /**
     * Generate JSON response.
     *
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function generateResponse(array $data, int $statusCode): JsonResponse
    {
        if ($this->transform) {
            $transformedData = $this->transform($data['data']);
            $data = array_merge($data, $transformedData);
        }

        return response()->json($data, $statusCode);
    }

    /**
     * Transform data using ResponseTransformer.
     *
     * @param mixed $data
     * @return mixed
     */
    private function transform($data)
    {
        $responseTransform = app()->make(ResponseTransformer::class);
        return $responseTransform->transform($data, $this->transform);
    }
}
