<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        //
        $request->validate(
            [
                'email'=>'required|email|unique:users|max:300',
                'name'=>'required|string|max:300',
                'password'=>'required|confirmed|string|min:8'
            ]
        );
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $msg = $user->save() ? ["User registered"] : ["User registration failed"];
        return $msg;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        //
        $request->validate(
            [
                'email'=>'required|email|max:300',
                'password'=>'required|string|min:8'
            ]
        );
        $user = User::where("email",$request->email)->first();
        if ($user && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('myAppToken')->plainTextToken;
            return response([
                'user'=>$user,
                'token'=>$token
            ], 201);
        }
        else{
            return response([
                "Invalid Credentials"
            ], 401);
        }
    }
    /**
     * Clear token.
     */
    public function logout(Request $request)
    {
        if (Auth::check())
        {
            // $request->user()->tokens->each(function ($token, $key) {
            //      $token->delete();
            //  });
            // OR
            $request->user()->tokens()->delete();
             return response()->json([
                'status'    => 1,
                'message'   => 'User Logout',
            ], 200);
        }
        else{ 
            return response(['error'=>'Unauthorised'] , 403);
        } 
    }
    /** 
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
