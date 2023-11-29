<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'role'=>'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = new User();
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        // return response($request,Response::HTTP_OK);
        $credentials=$request->validate([
            'email' => ['required','email'],
            'password' =>['required']
        ]);
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token',$token,60*24);
            return response(["user_id"=>$user->id], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response(["message"=>'Las credenciales no son correctas'],Response::HTTP_UNAUTHORIZED);
        }

    }

    public function userProfile(Request $request){
        return response()->json([
            "message"=>"Metodo USERPROFILE OK",
            // "userData"=> auth()->user
        ], Response::HTTP_OK);
    }

    public function logout(){
        $cookie = Cookie::forget('cookie_token');
        return response(["message"=>'Se cerro la sesión correctamente!'],Response::HTTP_OK)->withCookie($cookie);
    }

    public function allUsers(){
        return response()->json([
            "message"=>"Metodo ALLUSERS OK"
        ]);
    }
}
