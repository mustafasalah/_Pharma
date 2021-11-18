<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @author @OxSama
     * Register new users and send access tokens to them
     * @param Illuminate\Http\Request
     * @return response containing App\Models\User , Token
     */
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

    /**
     * @author @OxSama
     * Login users and send access tokens to them
     * @param Illuminate\Http\Request
     * @return response containing App\Models\User , Token
     */
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

    /**
     * @author @OxSama
     * Logout users delete access tokens
     * @param Illuminate\Http\Request
     * @return response 'message' : 'Logged Out'
     */
    public function logout(Request $request)
    {
        /**
         * Might find error but its working
         */
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
