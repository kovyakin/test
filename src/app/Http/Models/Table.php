<?php

namespace Kovyakin\Test\app\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'table';
    protected $fillable=[
        'name'
    ];

}
