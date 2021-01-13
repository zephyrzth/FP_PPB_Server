<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            $success['id'] = $user->id;
            return response()->json(['status' => "success", 'message' => "Berhasil login", 'data' => $success], $this->successStatus);
        }
        else{
            return response()->json(['status' => "error", 'message' => "Username/password salah"], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'message' => $validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['status' => "success", 'message' => "Berhasil login", 'data' => $success], $this->successStatus);
    }

    public function whoami()
    {
        $user = Auth::user();
        return response()->json(['status' => "success", 'message' => "Berhasil login", 'data' => $user], $this->successStatus);
    }
}