<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** 
     * Success Response
     */
    public function successResponse($attributes = [], $message, $code)
    {
        return response()->json([
            'status' => true,
            'data' => $attributes,
            'message' => $message
        ]);
    }

    /** 
     * Error Response
     */
    public function errorResponse($errors = [], $message, $code)
    {
        return response()->json([
            'status' => false,
            'errors' => $errors
        ]);
    }
}
