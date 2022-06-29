<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{

    public function options()
    {
        return $this->hasMany(RestOption::class);
    }
}
