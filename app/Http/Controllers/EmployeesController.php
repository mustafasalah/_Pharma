<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\PharmacyBranches;
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

        foreach ($Employees as $Employee) {

            $data = [
                "id" => $Employee->id,
                'fullname' => $Employee->fullname,
                "username" => $Employee->username,
                "phone_number" => $Employee->phone_number,
                "gender" => $Employee->gender,
                "role" => $Employee->role,
                "work_from" => $Employee->work_from,
                "work_to" => $Employee->work_to,
                "last_seen" => $Employee->last_seen,
                "joining_date" => $Employee->created_at
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
    public function store(Request $request, $userid, $branchid)
    {
        //
         //$status = PharmacyBranches::firstOrCreate(["status" => $request->input("status")]);

        $data = [
            //"user_id" => $userid,
            "role" => $request->input("role"),
            'work_from' => $request->input("work_from"),
            "work_to" => $request->input('work_to')
        ];

        if ($employee = Employees::create($data)) {
            return response([
                "id" => $employee->id,
                "pharmacyBranchId" => $branchid,
                'full_name' => $employee->fullname,
                "username" => $employee->username,
                "phone_number" => $employee->phone_number,
                "gender" => $employee->gender,
                "role" => $employee->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->joining_date,
                "last_seen" => $employee->last_seen,
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
    public function show($id)
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
        $data = [
            "id" => $id,
            "fullname" => $request->input("full_name"),
            "role" => $request->input("role"),
            'work_from' => $request->input("work_from"),
            "work_to" => $request->input('work_to')
        ];

        $employee = Employees::where('id', $id)->first();
        if ($employee->update($data)) {
            return response([
                "id" => $employee->id,
                'full_name' => $employee->fullname,
                "username" => $employee->username,
                "phone_number" => $employee->phone_number,
                "gender" => $employee->gender,
                "role" => $employee->role,
                "work_from" => $employee->work_from,
                "work_to" => $employee->work_to,
                "joining_date" => $employee->joining_date,
                "last_seen" => $employee->last_seen,
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
