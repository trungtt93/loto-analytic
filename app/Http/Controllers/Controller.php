<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function responseSuccess($data): JsonResponse
    {
        return response()->json($data);

    }
}
