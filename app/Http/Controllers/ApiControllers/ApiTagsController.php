<?php

namespace app\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Models\TagsModel;
use App\Models\TaskModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query()->where('id', $request->user()->id)->first();
//        $tokens = $user->tokens();
//
//        dd($request->bearerToken());
//        dd($user);
//        dd($request->user()->id);
//        dd($request->bearerToken());
        return TagsResource::collection(TagsModel::query()->where('user_id', $user->id)->get());
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
        $validator = Validator::make($request->all(), [
            'value' => 'required|min:3|max:20',
        ]);

        if ($validator->fails()) {
            return ['result' => 'error', 'message' => $validator->errors()];
        }
        TagsModel::query()->where('id', $id)
            ->update([
                'title' => $request->value
            ]);

        return ['result' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
