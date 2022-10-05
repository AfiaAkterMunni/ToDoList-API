<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
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

    public function login(LoginUserRequest $request)
    {
        try{
            $user =[
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            if(auth()->attempt($user))
            {
                $token = Auth::user()->createToken('accessToken')->accessToken;
                return response()->json([
                    'error' => false,
                    'message' => 'Login Successfully Complete!!',
                    'data' => ['token' => $token]
                ], 200);
            }
            else
            {
                throw new Exception("UnAuthorized Access!!", 401);
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
    public function me()
    {
        try {
            return response()->json([
                'error' => false,
                'message' => 'LogedIn User Details',
                'data' => ['user' => Auth::user()]
            ], 200);
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
