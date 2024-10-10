<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Team;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $data=$request->validate([
            'email'=> 'required|email|string',
            'password'=>'required|min:8'
        ]);
        $user=user::where('email',$data['email'])->first();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            if($user["is_admin"]){
                $token=$user->createToken($user->name .'-authtoken')->plainTextToken;
                return response()->json([
                    "token"=>$token,
                    "is_admin"=>true
                ]);

            }
            if($user["mine_admin"]){
                $token=$user->createToken($user->name .'-authtoken')->plainTextToken;
                return response()->json([
                    "token"=>$token,
                    "mine_admin"=>true
                ]);
            }
            $token=$user->createToken($user->name .'-authtoken')->plainTextToken;
            return response()->json([
                "token"=>$token
            ]);
        }else{
            return response()->json([
                "masseg"=>"no .,/"
            ]);
        }

    }
    public function regster(Request $request,User $user)
    {
        $data=$request->validate([
            'name'=>'required|string|max:50',
            'email'=> 'required|email|string|unique:users',
            'password'=>'required|string|min:8|confirmed'
        ]);

        $user->name=$data['name'];
        $user->email=$data['email'];
        $user->password=Hash::make($data['password']);
        $user->save();
        return response()->json([
            "masseg"=>"welcom"
        ]);

    }
    public function logout(Request $request,User $user)
    {
        $user->tokens()->delete();
            return response()->json([
                "massage"=>"logout"
            ],200);
    }

    public function index()
    {
        $event=Event::all();
        $contact=Contact::all();
        $team=Team::all();
        $client=Clients::all();
        $user=User::all();
        return response()->json([
            $event,
            $contact,
            $team,
            $client,
            $user
        ],200);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
