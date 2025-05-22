<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function responseSuccess(): JsonResponse
    {
        return response()->json(['success' => true]);
    }
}
