<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(string $message, int $statusCode = 400, array $errors = [])
    {
        $data = [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ];

        parent::__construct($data, $statusCode);
    }
}
