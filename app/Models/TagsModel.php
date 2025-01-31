<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class TagsModel extends Model
{
    use HasApiTokens;
    protected $table = 'tags';
    protected $fillable = [
        'user_id',
        'title',
    ];
    //
}
