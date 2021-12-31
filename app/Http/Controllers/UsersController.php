<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355

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
<<<<<<< HEAD
       $Users = User::all();
       
       $response = collect();
       //$state = request('state');
        foreach($Users as $user){

            $data=[
=======
        $Users = User::all();

        $response = collect();
        //$state = request('state');
        foreach ($Users as $user) {

            $data = [
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
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

<<<<<<< HEAD
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }
=======
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        //
        $response = collect();
        $data=[
          
            'first_name' => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "username" => $request->input('username'),
=======
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
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
            "email" => $request->input('email'),
            "role" => $request->input('role'),
            "gender" => $request->input('gender'),
            "phone_number" => $request->input('phone_number'),
            "status" => $request->input('status'),
<<<<<<< HEAD
            "state" => $request->input('state'),
            "city" => $request->input('city'),
            "address" => $request->input('address'),

        ];
        User::create($data)->save();
  /*      $response->push($data);
        if($response){
         echo "record created";
        return $response;
    }
        else 
        echo "null!!!"; 
        */
    }
    
    
=======
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


>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        //
<<<<<<< HEAD
        $Users=User::where('username',$username)->get();

        $response=collect();
        foreach($Users as $user){

            $data=[
=======
        $Users = User::where('username', $username)->get();

        $response = collect();
        foreach ($Users as $user) {

            $data = [
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
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
<<<<<<< HEAD
=======

>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
            $response->push($data);
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
<<<<<<< HEAD
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
=======
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // 
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
            "id" => $id,
            'first_name' => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "username" => $request->input('username'),
            "email" => $request->input('email'),
            "role" => $request->input('role'),
            "gender" => $request->input('gender'),
            "phone_number" => $request->input('phone_number'),
            "status" => $request->input('status'),
            "address_id" => $address->id,
        ];
        $user = User::where('id', $id)->first();
        if ($user->update($data)) {
            return response([
                'first_name' => $user->first_name,
                "last_name" => $user->last_name,
                "username" => $user->username,
                "email" => $user->email,
                "role" => $user->role,
                "gender" => $user->gender,
                "phone_number" => $user->phone_number,
                "status" => $user->status, 
                "state" => $user->address->state,
                "city" => $user->address->city,
                "address" => $user->address->address
            ], 200);
        } else {
            abort(500, "Database Error.");
        }
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
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
<<<<<<< HEAD
        if($response = User::destroy($id))

        return response(['id'=>'$id',200]);

          else
          return response(['id'=>'$id',400]);
          
    }
}

=======
        if ($response = User::destroy($id))
            return response(['id' => $id, 200]);

        else
            return response(['id' => $id, 400]);
    }
}
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
