<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchRecordResource;
use App\Models\SearchRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SearchRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $searchRecordsByUser = $user->searchRecords;
        // $searchRecords = SearchRecord::all();


        return response()->json(
            [
                'LogInUser' => $user->name,
                'keyword' => SearchRecordResource::collection($searchRecordsByUser)
            ]
        );
        // return response()->json([
        //     "logInUser" => $user->name,
        //     "searchRecordsByUser" => $searchRecordsByUser
        // ]);
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
    public function show(string $keyword)
    {

        $searchRecordsByKeyword = SearchRecord::where('keyword', $keyword)->first();
        if (is_null($searchRecordsByKeyword)) {
            return response()->json(['message' => "There is no searched keyword"]);
        }
        //usersByKeyword are  the number of users who searched for a keyword
        $usersByKeyword = $searchRecordsByKeyword->users()->count();
        return response()->json([
            'the number of users who searched for => ' . "$keyword " => $usersByKeyword,
        ]);
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
        //
    }
}
