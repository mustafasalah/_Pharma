<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Users = User::all();

        $response = collect();
        //$state = request('state');
        foreach ($Users as $user) {

            $data = [
                "id" => $user->id,
                'first_name' => $user->first_name,
                "last_name" => $user->last_name,
                "username" => $user->username,
                "email" => $user->email,
                "role" => $user->role,
                "gender" => $user->gender,
                "phone_number" => $user->phone_number,
                "state" => $user->address->state,
                "city" => $user->address->city,
                "address" => $user->address->address,
                "status" => $user->status,
                "last_seen" => $user->last_seen,
                "joining_date" => $user->create_time
            ];
            $response->push($data);
        }
        return $response;
    }
    /*{
        id: 3,
        first_name: "Mona",
        last_name: "Hassan",
        username: "monnna",
        email: "mona_hassssan@hotmail.com",
        role: "user",
        gender: "f",
        phone_number: "",
        state: "",
        city: "",
        address: "",
        status: "non-active",
        last_seen: "1 day ago",
        joining_date: "24-10-2021",
    },*/


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([]);
        if ($request->anyFilled(["state", "city", "address"])) {
            $address = Addresses::where([
                "state" => $request->input('state'),
                "city" => $request->input('city'),
                "address" => $request->input('address')
            ])->first();

            if ($address === null) {
                $address = Addresses::create([
                    "state" => $request->input('state'),
                    "city" => $request->input('city'),
                    "address" => $request->input('address')
                ]);
            }
        }

        $data = [
            'first_name' => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "username" => $request->input('username'),
            "password" => Hash::make($request->input('password')),
            "email" => $request->input('email'),
            "role" => $request->input('role'),
            "gender" => $request->input('gender'),
            "phone_number" => $request->input('phone_number'),
            "status" => $request->input('status'),
            "address_id" => $address->id,
        ];

        if ($user = User::create($data)) {
            return response([
                "id" => $user->id,
                'first_name' => $user->first_name,
                "last_name" => $user->last_name,
                "username" => $user->username,
                "email" => $user->email,
                "role" => $user->role,
                "gender" => $user->gender,
                "phone_number" => $user->phone_number,
                "status" => $user->address->status,
                "state" => $user->address->state,
                "city" => $user->address->city,
                "address" => $user->address->address,
                "joining_date" => $user->created_at,
                "last_seen" => $user->last_seen
            ], 200);
        } else {
            abort(500, "Database Error.");
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        //
        $Users = User::where('username', $username)->get();

        $response = collect();
        foreach ($Users as $user) {

            $data = [
                "id" => $user->id,
                'first_name' => $user->first_name,
                "last_name" => $user->last_name,
                "username" => $user->username,
                "email" => $user->email,
                "role" => $user->role,
                "gender" => $user->gender,
                "phone_number" => $user->phone_number,
                "state" => $user->address->state,
                "city" => $user->address->city,
                "address" => $user->address->address,
                "status" => $user->status,
                "last_seen" => $user->last_seen,
                "joining_date" => $user->create_time
            ];

            $response->push($data);
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($response = User::destroy($id))
            return response(['id' => $id, 200]);

        else
            return response(['id' => $id, 400]);
    }
}
