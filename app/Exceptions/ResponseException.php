<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ResponseException extends Exception
{
	public function responseJson()
	{
        return new JsonResponse([
            'message' => 'This is a custom response exception.',
        ], 500);
	}
}
