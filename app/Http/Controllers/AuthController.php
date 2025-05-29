<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => bcrypt($validator['password']),
        ]);

        return response()->json(["response" => "Record has been Successfully Saved", "user" => $user ,200]);
    }

    public function login(Request $request)
    {
        /*$validatedData = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        $credentials = [
            'email' => $validatedData['email'], 
            "password" => $validatedData['password']
        ];

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(["user" => $user, "token" => $token], 200);
        }
        else
        {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }**/

        $user = User::select("id", "name", "email", "password")->where('email', $request->email)->first();

        if($user && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['message'=>'successful', 'user'=>$user, 'token'=>$token], 200);
        }
        else
        {
            return response()->json(['message'=>'Failed'], 401);
        }
    }

    public function index(string $id)
    {
        $users = User::find($id);
        $user= user::where("id", $id)->first();
        //return response()->json(["user" => $users]);

        return Response(["users" => $users]);
    }
}
