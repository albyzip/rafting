<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestOption extends Model
{
    protected $hidden = ['created_at', 'updated_at','rest_id','options_id'];

    public function options()
    {
        return $this->belongsTo(Option::class);
    }
}
