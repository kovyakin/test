<?php

namespace App\Http\Resources;

use App\Models\TagsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tags = collect();
        $tags_id =collect(json_decode($this->tags_id)) ;
        $tags_id->each(function ($id) use ($tags) {
            $tag = TagsModel::query()-> where('id',$id)->first();
            if(isset($tag->id)){
                $tags->push(['id'=>$tag->id,'title'=>$tag->title]);
            }

        });

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'tags_id'=> $tags,
            'text'=>$this->text,
            'created_at'=>$this->created_at->toDateTimeString(),
        ];
    }
}
