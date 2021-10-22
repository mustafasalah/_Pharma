<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields= $request->validate(
            [
                'first_name'=>'required|string',
                'last_name'=>'required|string',
                'username'=>'required|unique:users,username|string',
                'email'=>'required|unique:users,email|email',
                'phone_number'=>'required',
                'password'=>'required',
                'gender'=>'required'
            ]
        );
        $user = User::create(
            [
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'phone_number'=>$fields['phone_number'],
                'password'=>bcrypt($fields['password']),
                'gender'=>$fields['gender'],
                'role'=>'user',
                'status'=>'non-activated',
            ]
        );
        $token=$user->createToken('PharmaToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);

    }

    public function login(Request $request)
    {
        $fields= $request->validate(
            [
                'username'=>'required|string',
                'password'=>'required|string',
                ]
        );
        $user = User::where(
            'username', $fields['username']
        )->first();
        if(!$user || !Hash::check($fields['password'], $user->password) ){
            return response(
                [
                    'message' => 'Check Username and Password'
                ],401
            );
        }
        $token=$user->createToken('PharToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
