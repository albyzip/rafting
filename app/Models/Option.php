<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $hidden = ['created_at', 'updated_at','id','rest_types_id'];

}
