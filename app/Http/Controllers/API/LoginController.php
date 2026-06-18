<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 'false',
                    'message' => 'Validation Error',
                    'error' => $validator->errors()

                ], 422);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => 'false',
                    'message' => 'Invalid Credential!',
                ], 401); //Unauthorize
            }
            $user->tokens()->delete();

            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'token' => $token,
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout Success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
