<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ApiException extends \Exception
{
    protected $customCode;

    protected function getCustomCode(): string {
        return $this->customCode ?? 'error';
    }

    public function render($request)
    {
        return new JsonResponse([
            'status' => false,
            'code' => $this->getCustomCode(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
