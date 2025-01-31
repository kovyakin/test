<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TasksResource;
use App\Models\TagsModel;
use App\Models\TaskModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query()->where('id', $request->user()->id)->first();

        return TasksResource::collection(TaskModel::query()->where('user_id', $user->id)->get());
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
        $user_id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'value'=>'required|array',
            'value.0' => 'required|min:3|max:20',
            'value.1' => 'required|min:3|max:200',
            'value.3' => 'array',
        ]);

        $title = $request->value[0];
        $text = $request->value[1];
        $selectAll = $request->value[2];
        $selectItem = $request->value[3];

        if($selectAll){
            $selectItem = TagsModel::query()
                ->where('user_id', $user_id)
                ->pluck('id');
        }

        if ($validator->fails()) {
            return ['result' => 'error', 'message' => $validator->errors()];
        }


        TaskModel::query()->create([
            'user_id' => $user_id,
            'title'=>$title,
            'text'=>$text,
            'tags_id'=>count($selectItem) > 0 ? $selectItem->toJson(): null,
        ]);

        return ['result' => 'success'];
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
        TaskModel::query()->where('id', $id)
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
        $isDel =  TaskModel::query()->where('id', $id)->delete();

//        $isDel = TagsModel::query()->find($id)->first();

        if($isDel){
            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }
}
