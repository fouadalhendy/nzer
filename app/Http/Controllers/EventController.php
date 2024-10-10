<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Event;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event=event::all();
        return response()->json([
            $event
        ]);
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
        // 'name',
        // 'event_cost',
        // 'location',
        // 'event_img'
        $this->authorize('mine_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string',
            'event_cost'=>'required|string',
            'location'=>'required|string',
            'event_img'=>'required|image',
            'client_id'=>'required'
        ]);
        if ($request->hasFile('event_img')) {
            $img=$request->event_img;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('contactimges'), $imgname);
        }
        $event=new event();
        $event->name=$dat['name'];
        $event->event_cost=$dat['event_cost'];
        $event->location=$dat['location'];
        $event->user_id=auth()->user()->id;
        $event->client_id=$dat['client_id'];
        $event->event_img=$imgname;
        $event->save();
        return response()->json(["masseg"=>"ok crate"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('mine_admin',User::class);
        $dat=$request->validate([
            'name'=>'required|string',
            'event_cost'=>'required|string',
            'location'=>'required|string',
            'event_img'=>'image',
            'client_id'=>'required'
        ]);
        if ($request->hasFile('event_img')) {
            $img=$request->event_img;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('contactimges'), $imgname);
            $event->event_img=$imgname;
        }
        $event->name=$dat['name'];
        $event->event_cost=$dat['event_cost'];
        $event->location=$dat['location'];
        $event->user_id=auth()->user()->id;
        $event->client_id=$dat['client_id'];

        $event->save();
        return response()->json(["masseg"=>"ok update"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(["masseg"=>"ok delete"]);
    }
}
