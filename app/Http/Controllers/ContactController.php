<?php

namespace App\Http\Controllers;

use App\Http\Resources\Contact as ResourcesContact;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest("id")->paginate(5)->withQueryString();
        return ContactResource::collection($contacts);
        // return new ContactCollection(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "country_code" => "required|min:1|max:265",
            "phone_number" => "required"
        ]);

        $contact = Contact::create([
            "name" => $request->name,
            "country_code" => $request->country_code,
            "phone_number" => $request->phone_number
        ]);

        return new ContactDetailResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);

        if (is_null($contact)) {
            return response()->json([
                "message" => "Contact is not found",
            ], 404);
        };

        return new ContactDetailResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // nullable is for partially data updating
        $request->validate([
            "name" => "nullable|min:3|max:20",
            "country_code" => "nullable|integer|min:1|max:265",
            "phone_number" => "nullable|min:7|max:15"
        ]);

        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json([
                "message" => "Contact is not found",
            ], 404);
        };

        // $contact->update([
        //     "name" => $request->name,
        //     "country_code" => $request->country_code,
        //     "phone_number" => $request->phone_number
        // ]);

        // $contact->update($request->all());


        // Partially update data logic
        if ($request->has('name')) {
            $contact->name = $request->name;
        }

        if ($request->has('country_code')) {
            $contact->country_code = $request->country_code;
        }

        if ($request->has('phone_number')) {
            $contact->phone_number = $request->phone_number;
        }

        $contact->update();

        return new ContactDetailResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if (is_null($contact)) {
            return response()->json([
                "message" => "Contact is not found",
            ], 404);
        }
        $contact->delete();

        // return response()->json([], 204);
        return response()->json([
            "message" => "Contact is deleted",
        ]);
    }
}
