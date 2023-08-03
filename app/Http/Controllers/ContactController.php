<?php

namespace App\Http\Controllers;

use App\Http\Resources\Contact as ResourcesContact;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\SearchRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where("name", "like", "%" . $keyword . "%");

                // $exists = SearchRecord::where('keyword', $keyword)->exists(); // exists method return boolean

                $exists = SearchRecord::where('keyword', $keyword)->where('user_id', Auth::id())->exists(); // exists method return boolean
                // dd($exists);
                if (!$exists) {
                    $searchRecord = SearchRecord::create([
                        "keyword" => $keyword,
                        "user_id" => Auth::id(),
                    ]);


                    $searchRecord = SearchRecord::where('keyword', $keyword)->first();
                    // dd($searchRecord);
                    $searchRecord->users()->attach(Auth::id());
                }
            });
        })
            ->where('user_id', Auth::id())->withTrashed()->paginate(5)->withQueryString();

        if (empty($contacts[0])) {
            return response()->json([
                "loginUser" => Auth::user()->name,
            ]);
        }
        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:contacts,name",
            "country_code" => "required|min:1|max:265",
            "phone_number" => "required|unique:contacts,phone_number"
        ], [
            "name.unique" => "the name has already stored",
            "phone_number.unique" => "phone number has already stored"

        ]);

        $contact = Contact::create([
            "name" => $request->name,
            "country_code" => $request->country_code,
            "phone_number" => $request->phone_number,
            "user_id" => Auth::id()
        ]);

        return new ContactDetailResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {

        $contact = Contact::find($id);

        if (is_null($contact)) {
            return response()->json([
                "message" => "Contact is not found",
            ], 404);
        };

        try {
            $this->authorize('view', $contact);
        } catch (AuthorizationException $e) {
            // Authorization failed
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

        try {
            $this->authorize('delete', $contact);
        } catch (AuthorizationException $e) {
            // Authorization failed
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $contact->delete();

        // return response()->json([], 204);
        return response()->json([
            "message" => "Contact has softDeleted",
        ]);
    }


    public function multipleDelete(Request $request)
    {
        $ids = $request->ids;
        // if (is_array($ids)) {
        //     return $ids;
        // }

        Contact::destroy($ids);

        return response()->json([
            'message' => "you have deleted multiple records ",
        ]);
    }





    public function restore($id)
    {

        $softdeletedConact = Contact::withTrashed()->find($id);
        if (is_null($softdeletedConact)) {
            return response()->json([
                'message' => 'Softdeleted is not found'
            ]);
        }

        $softdeletedConact->restore();

        return response()->json([
            'message' => "softdeletedContact has been restored"
        ]);
    }


    public function restoreAll()
    {
        // return response()->json([
        //     'messae' => "I'm am resotre all"
        // ]);
        Contact::onlyTrashed()->restore();

        return response()->json([
            'message' => "All softDeleted records has restored"
        ]);
    }


    public function forceDelete($id)
    {
        $contact = Contact::onlyTrashed()->find($id);

        if (is_null($contact)) {
            return response()->json([
                "message" => "softDeleted contact is not found",
            ], 404);
        }

        try {
            $this->authorize('delete', $contact);
        } catch (AuthorizationException $e) {
            // Authorization failed
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $contact->forceDelete();

        return response()->json([
            'message' => "contact has parmanmentyl deleted",
        ]);
    }


    public function forceDeleteAll()
    {


        $trashContacts = Contact::onlyTrashed()->forceDelete();
        return response()->json([
            'message' => "SoftDeleted Contacts has parmanmentyl deleted",
        ]);
    }
}
