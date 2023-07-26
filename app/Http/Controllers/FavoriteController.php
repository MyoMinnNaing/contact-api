<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'contact_id' => 'required|exists:contacts,id|unique:favorites,contact_id',
        ]);

        $contact = Contact::find($request->contact_id);

        if (Auth::id() != $contact->user_id) {
            return response()->json([
                'message' => "U are not allowed",
            ]);
        }




        $favorite = new Favorite();
        $favorite->user_id = Auth::id();
        $favorite->contact_id = $contact->id;
        $favorite->save();

        return response()->json($favorite);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favorite = Favorite::find($id);
        // return $favorite;
        if (is_null($favorite)) {
            return response()->json([
                "message" => "Contact is not found",
            ], 404);
        }

        if (Auth::id() != $favorite->user_id) {
            return response()->json([
                'message' => "U are not allowed",
            ]);
        }
        $favorite->delete();
        return response()->json([
            "message" => "Favorite is deleted",
        ]);
    }
}
