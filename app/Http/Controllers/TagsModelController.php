<?php

namespace App\Http\Controllers;

use App\Models\TagsModel;
use Illuminate\Http\Request;

class TagsModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('todolist.tags')->with(['active_tags'=> true]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TagsModel $tagsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TagsModel $tagsModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TagsModel $tagsModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TagsModel $tagsModel)
    {
        //
    }
}
