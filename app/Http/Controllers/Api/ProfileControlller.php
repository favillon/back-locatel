<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\ProfileResource;

class ProfileControlller extends Controller
{
    public function index(Request $request)
    {
        $userData = auth()->user();
        $userData['account'] = $userData->account()->first();
        return response()->json([
            'status'  => true,
            'message' => 'Profile Information',
            'data'    => new ProfileResource($userData) 
        ], Response::HTTP_OK); //200
    }
}
