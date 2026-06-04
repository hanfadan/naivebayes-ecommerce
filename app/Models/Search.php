<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'searchs';
    public $timestamps = false;

    protected $fillable = ['name', 'view'];
}
