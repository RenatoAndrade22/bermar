<?php

namespace App\Exceptions;

use Exception;

class ApiErrorException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct($message = 'Erro ao cadastrar', $statusCode = 500)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->message,
            'code' => $this->statusCode,
        ], $this->statusCode);
    }
}
