<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class TaskModel extends Model

{
    use HasApiTokens;
    protected $table = 'task';

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'tags_id'
    ];

    protected $casts=[
        'created_at'=>'datetime:d-m-Y H:i:s'
    ];

    //
}
