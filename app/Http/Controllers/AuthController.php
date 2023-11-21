<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' =>['login','register']]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all,[
            'name' => 'required',
            'email'=> 'required|string|email|unique:users',
            'password'=>'required|string|confirmed|min:6'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
    }
    public function login(Request $request)
    {
    }
}