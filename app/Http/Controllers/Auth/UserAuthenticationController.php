<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationController extends Controller
{
    
    public function index(Request $request)
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function show($id)
    {
        $user = User::find($id);
        return  new UserResource($user);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->update();
        return 'user updated';
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->tokens()->delete();
        $user->delete();
        return 'destroy';
    }


    function login(Request $request) {

        $request->validate([
           'email' => 'required|exists:users,email',
           'password' => 'required',
        ]);

        $user = User::where('email',$request->email)->first();
        if(Hash::check( $request->password , $user->password))
        {
            $user->tokens()->delete();
            $token = $user->createToken($request->email)->plainTextToken;
            return [
               'user'=> $user,
               'token'=> $token
            ];
        }
        else{
            return response()->json([
                'status'=>false ,
                'messages'=>[
                    'password'=>'incorrect password'
                ]
            ]);
        }

    }
}
