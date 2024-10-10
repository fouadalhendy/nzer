<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('mine_admin',User::class);
        $contact=Contact::all();
        return response()->json([$contact],201);
    }

    // 'phone',
    // 'email',
    // 'insta',
    // 'faceboock',
    // 'linkedin',
    // 'telegram',
    // 'logo'
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'phone'=>'required|string|max:15',
            'email'=>'required|email',
            'insta'=>'required|string',
            'faceboock'=>'required|string',
            'linkedin'=>'required|string',
            'telegram'=>'required|string',
            'logo'=>'required|image'
        ]);
        if ($request->hasFile('logo')) {
            $img=$request->logo;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('contactimges'), $imgname);
        }
        $contact=new Contact();
        $contact->phone=$dat['phone'];
        $contact->email=$dat['email'];
        $contact->insta=$dat['insta'];
        $contact->faceboock=$dat['faceboock'];
        $contact->linkedin=$dat['linkedin'];
        $contact->telegram=$dat['telegram'];
        $contact->logo=$imgname;
        $contact->save();
        return response()->json(["masseg"=>"ok crate"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('is_admin',User::class);
        $dat=$request->validate([
            'phone'=>'required|string|max:15',
            'email'=>'required|email',
            'insta'=>'required|string',
            'faceboock'=>'required|string',
            'linkedin'=>'required|string',
            'telegram'=>'required|string',
            'logo'=>'image'
        ]);
        if ($request->hasFile('logo')) {
            $img=$request->logo;
            $imgname = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('contactimges'), $imgname);
            $contact->logo=$imgname;
        }
        $contact->phone=$dat['phone'];
        $contact->email=$dat['email'];
        $contact->insta=$dat['insta'];
        $contact->faceboock=$dat['faceboock'];
        $contact->linkedin=$dat['linkedin'];
        $contact->telegram=$dat['telegram'];
        $contact->save();
        return response()->json(["masseg"=>"ok update"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('is_admin',User::class);
        $contact->delete();
        return response()->json(["masseg"=>"ok delete"]);
    }
}
