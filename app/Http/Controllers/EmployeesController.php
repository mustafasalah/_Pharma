<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\PharmacyBranches;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\Diff\Diff;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Employees = Employees::all();

        $response = collect();

        foreach ($Employees as $employee) {

            $data = [
                "id" => $employee->id,
                'full_name' => $employee->user->fullname(),
                "username" => $employee->user->username,
                "phone_number" => $employee->user->phone_number,
                "gender" => $employee->user->gender,
                "role" => $employee->user->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->created_at,
                "last_seen" => $employee->user->last_seen,
                "status" => $employee->pharmacyBranch->status
            ];
            $response->push($data);
        }
        return $response;
    }
    /*{
        id: 1,
        full_name: "Mustafa Salah",
        username: "mustafa_salah",
        phone_number: "+249965474730",
        gender: "m",
        role: "pharmacy owner",
        work_from: "",
        work_to: "",
        last_seen: "4 hours ago",
        joining_date: "12-10-2019",
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $branchid)
    {
        //
        //$status = PharmacyBranches::firstOrCreate(["status" => $request->input("status")]);

        $data = [
            "user_id" => $request->input("user_id"),
            "pharmacy_branch_id" => $branchid,
            'work_from' => $request->input("work_from"),
            "work_to" => $request->input('work_to')
        ];

        if ($employee = Employees::create($data)) {

            $employee->user->role = $request->input("role");
            $employee->user->save();
            $employee->refresh();

            return response([
                "id" => $employee->id,
                "pharmacyBranchId" => $branchid,
                'full_name' => $employee->user->fullname(),
                "username" => $employee->user->username,
                "phone_number" => $employee->user->phone_number,
                "gender" => $employee->user->gender,
                "role" => $employee->user->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->created_at,
                "last_seen" => $employee->user->last_seen,
                "status" => $employee->pharmacyBranch->status
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
    public function show($branchid)
    {
        //
        $Employees = Employees::where("pharmacy_branch_id" ,$branchid);

        $response = collect();

        foreach ($Employees as $employee) {

            $data = [
                "id" => $employee->id,
                'full_name' => $employee->user->fullname(),
                "username" => $employee->user->username,
                "phone_number" => $employee->user->phone_number,
                "gender" => $employee->user->gender,
                "role" => $employee->user->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->created_at,
                "last_seen" => $employee->user->last_seen,
                "status" => $employee->pharmacyBranch->status
            ];
            $response->push($data);
        }
        return $response;
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
        $data = [
            'work_from' => $request->input("work_from"),
            "work_to" => $request->input('work_to')
        ];



        $employee = Employees::findOrFail($id);

        if ($employee->update($data)) {

            $employee->user->role = $request->input("role");
            $employee->user->save();
            $employee->refresh();

            return response([
                "id" => $employee->id,
                'full_name' => $employee->user->fullname(),
                "username" => $employee->user->username,
                "phone_number" => $employee->user->phone_number,
                "gender" => $employee->user->gender,
                "role" => $employee->user->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->created_at,
                "last_seen" => $employee->user->last_seen,
                "status" => $employee->pharmacyBranch->status
            ], 200);
        } else {
            abort(500, "Database Error.");
        }
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
        $response = Employees::destroy($id);

        return $response;
    }
}
