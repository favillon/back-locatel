<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Validator};
use Symfony\Component\HttpFoundation\Response;

use Ramsey\Uuid\Uuid;

use App\Enums\TransactionTypeEnum;
use App\Models\{User, Account};

class LoginController extends Controller
{
    private $createAccount = true;
    private $accountType   = TransactionTypeEnum::DEPOSIT;

    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),[
                'name'            => 'required',
                'email'           => 'required|email|unique:users,email',
                'identification'  => 'required|unique:users,identification',
                'password'        => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], Response::HTTP_UNAUTHORIZED); //401
            }

            $user  = User::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'identification' => $request->identification,
                'password'       => $request->password
            ]);

            if ($this->createAccount) {
                $this->_createAccount($user);
            } 

            return response()->json([
                'status'  => true,
                'message' => 'User created successfully',
                'attributes' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'identification' => $request->identification,
                ],
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
                    'name' => $user->name,
                    'email' => $user->email,
                    'identification' => $user->identification,
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

    private function _createAccount(User $user)
    {
        $uuid = Uuid::uuid4();
        $account = Account::create([
            'account_number'  => $uuid->toString(),
            'user_id'         => $user->id,
            'account_type_id' => $this->accountType,
            'balance'         => 0
        ]);
    }
 }
