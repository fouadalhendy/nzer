<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients=Clients::all();
        return response()->json([$clients]);
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string|max:15',
            'logo'=>'required|image'
        ]);
        if ($request->hasFile('logo')) {
            $img=$request->logo;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('clientimges'), $imgname);
        }
        $clients=new clients();
        $clients->name=$dat['name'];
        $clients->logo=$imgname;
        $clients->save();
        return response()->json(["masseg"=>"ok crate"]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clients $client)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string|max:15',
            'logo'=>'image'
        ]);
        if ($request->hasFile('logo')) {
            $img=$request->logo;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('clientimges'), $imgname);
            $client->logo=$imgname;
        }
        $client->name=$dat['name'];
        $client->save();
        return response()->json(["masseg"=>"ok update"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $client)
    {
        $this->authorize('is_admin',User::class);
        $client->delete();
        return response()->json(["masseg"=>"ok delete"]);
    }
}
