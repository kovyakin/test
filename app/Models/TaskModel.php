<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class TaskModel extends Model

{
    use HasApiTokens;
    protected $table = 'tasks';
    protected $fillable = [];
    //
}
