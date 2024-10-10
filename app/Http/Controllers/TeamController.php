<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('mine_admin',User::class);
        $team=Team::all();
        return response()->json([$team],201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string',
            'details'=>'required|string',
            'img'=>'required|image',
        ]);
        if ($request->hasFile("img")) {
            $img=$request->img;
            $imgname = time() . '.' . $img->getClientOriginalExtension();;
            $img->move(public_path('teamimges'), $imgname);
        }
        $team=new Team();
        $team->name=$dat['name'];
        $team->img_team= $imgname;
        $team->details=$dat['details'];
        $team->save();
        return response()->json(["masseg"=>"ok insert"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {

        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string',
            'details'=>'required|string',
            'img'=>'image',
        ]);
        if ($request->hasFile("img")) {
            $img=$request->img;
            $imgname = time() . '.' . $img->getClientOriginalExtension();;
            $img->move(public_path('teamimges'), $imgname);
            $team->img_team= $imgname;
        }

        $team->name=$dat['name'];
        $team->details=$dat['details'];
        $team->save();
        return response()->json(["massge"=>"ok update"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $this->authorize('is_admin',User::class);
        $team->delete();
        return response()->json(["massge"=>"ok delete"],200);
    }
}
