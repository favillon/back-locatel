<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Validator};
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),[
                'name'     => 'required',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], Response::HTTP_UNAUTHORIZED); //401
            }

            $user  = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'User created successfully',
                'token'   => $user->createToken('web')->plainTextToken
            ], Response::HTTP_CREATED); //201

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request) 
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'The credentiales are incorrect'
                ], Response::HTTP_UNPROCESSABLE_ENTITY); //422
            }
            return response()->json([
                'status'  => true,
                'attributes' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token'   => $user->createToken('web')->plainTextToken
            ], Response::HTTP_OK); //200

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request) 
    {
        $userData = auth()->user();
        $userData->tokens()->where('id', $userData->currentAccessToken()->id)->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // 204
    }
}
