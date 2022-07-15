<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|numeric|regex:/9[6-8]{1}[0-9]{8}/|digits:10|unique:users',
            'password' => 'required|min:8|max:16|confirmed',
            'email' => 'required|email|unique:users',
            'type' => 'required|in:corporate,individual',
            'is_admin' => 'required|boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'type' => $request->type,
            'is_admin' => $request->is_admin,
            'mobile_verified_code' => rand(11111, 99999),
        ]);

        // returning single value
        // return $request->address;

        // returning all the request values
        return $user;
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid username and password provided"], 404);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
        $request->validate([
            'mobile_number' => 'unique:users',
            'password' => 'min:8|max:16|confirmed',
            'email' => 'email|unique:users',
            'type' => 'in:corporate,individual',
            'is_admin' => 'boolean'
        ]);

        $res = User::find($id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'type' => $request->type,
            'is_admin' => $request->is_admin,
        ]);

        $errResponse = [
            "status" => false,
            "message" => "Update error"
        ];

        if (!$res) {
            return response()->json($errResponse, 404);
        }

        $successResponse = [
            "status" => true,
            "message" => "Success"
        ];

        return response()->json($successResponse, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        $user->delete();
        $successResponse = ["message" => "User deleted successfully"];
        return response()->json($successResponse, 200);
    }
}