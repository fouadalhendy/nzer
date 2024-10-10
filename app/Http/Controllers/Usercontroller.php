<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=User::all();
        return response()->json([$user],201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'is_admin'=>'boolean',
            'mine_admin'=>'boolean'
        ]);
        $user->is_admin=$dat['is_admin'];
        $user->mine_admin=$dat['mine_admin'];
        $user->save();
        return response()->json(["masseg"=>"ok"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('is_admin',User::class);
        $user->delete();
        return response()->json(["ok delete"]);
    }
}
