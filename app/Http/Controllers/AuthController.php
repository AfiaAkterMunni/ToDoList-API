<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            if($user)
            {
                $token = $user->createToken('accessToken')->accessToken;
                return response()->json([
                    'error' => false,
                    'message' => 'Registration Successfully Complete!!',
                    'data' => ['token' => $token]
                ], 200);
            }
            else
            {
                throw new Exception("Something went wrong!!", 500);
            }
        }
        catch (Exception $e) {
            $status = $e->getCode() > 500 ? 500 : $e->getCode();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], $status);
        }
    }
}
