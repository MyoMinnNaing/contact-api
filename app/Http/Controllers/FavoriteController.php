<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Favorite;
use App\Models\User;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        /*
          The whereHas method is used to filter the contacts
           based on their association with favorites.

           fetches all the contacts that have an associated favorite entry
            in the favorites table with the user_id equal to the ID of the currently authenticated user.
        */
        $userFavoriteContacts = Contact::whereHas('favorites', function (Builder $query) {
            $query->where('user_id', Auth::id());
        })->get();
        /*
          "select * from `contacts`
           where exists (select * from `favorites` where `contacts`.`id` = `favorites`.`contact_id` and `user_id` = Auth::id())
           and `contacts`.`deleted_at` is null"

       */

        return response()->json($userFavoriteContacts);
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
        // dd($contact);

        //$contact will be null when the contact have softdeleted
        if ($contact == null) {
            return response()->json([
                'message' => "Contact is not found",
            ]);
        }
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
