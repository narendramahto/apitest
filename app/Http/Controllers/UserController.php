<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    //
    public function store(Request $request)
 {

    $validator=Validator::make($request->all(),[
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6',
        'confirm_password'=>'required|confirmed|min:6',
    ],[
        'email.required'=>'Email is required',
        'email.email'=>'Email is invalid',
        'email.unique'=>'Email is already taken',
        "password.required"=>'Password is required',
        'password.min'=>'Password must be at least 6 characters',
        'confirm_password.required'=>'Confirm password is required',
        'confirm_password.confirmed'=>'password does not match'
    ]);
if($validator->fails()){
    return response()->json(['error'=>$validator->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);
}
    $user= new User();
    $user->name=$request->name;
    $user->email=$request->email;
    $user->password=Hash::make($request->password);
    $user->save();
    
    return response()->json([
        "message"=>"User created succesfully",
        "data"=>$user
    ],200);
 }
}
