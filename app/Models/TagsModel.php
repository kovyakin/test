<?php

namespace App\Models;

use App\Models\Scopes\TagsScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class TagsModel extends Model
{
    use HasApiTokens;
    protected $table = 'tags';
    protected $fillable = [
        'user_id',
        'title',
    ];

    protected $casts=[
        'created_at'=>'datetime:d-m-Y H:i:s'
    ];

    protected static function booted(): void
    {
//        static::addGlobalScope(new TagsScope);
    }
}
