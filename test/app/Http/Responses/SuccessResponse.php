<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
    public function __construct(iterable $data = [], int $statusCode = 200)
    {
        $data = [
            'status' => 'success',
            'data' => $data,
        ];

        parent::__construct($data, $statusCode);
    }
}
