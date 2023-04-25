<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function register(Request $request)
    {
        try {
            //Validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], //unique:users means that the email must be unique in the users table
                'password' => ['required', 'string', new Password], //confirmed means that the password must be confirmed
            ]);

            //Create User
            $user = User::create([
                'name' => $request->name, //name is the name of the column in the users table
                'email' => $request->email, //email is the name of the column in the users table
                'password' => Hash::make($request->password), //password is the name of the column in the users table
            ]);

            //Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            //Return Response
            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer', //Bearer is the type of token
                    'user' => $user,
                ],
                'User Registered'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Authentication Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            //Validate request
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'], //unique:users means that the email must be unique in the users table
                'password' => ['required', 'string'], //confirmed means that the password must be confirmed
            ]);

            //Check Credentials (Login)
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error(
                    ['message' => 'Unauthorized'],
                    'Authentication Failed',
                    500
                );
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('Invalid Password');
            }

            //Create Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            //Return Response
            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer', //Bearer is the type of token
                    'user' => $user,
                ],
                'Login Success'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        //Revoke Token
        $token = $request->user()->currentAccessToken()->delete();

        //Return Response
        return ResponseFormatter::success($token, 'Logout Success');
    }
    
    public function fetch(Request $request)
    {
        $user = $request->user();
        return ResponseFormatter::success($user, 'Data profile user berhasil diambil');
    }
}
