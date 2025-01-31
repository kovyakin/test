<?php

namespace app\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Models\TaskModel;
use Illuminate\Http\Request;

class ApiTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return TagsResource::collection(TaskModel::class);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
