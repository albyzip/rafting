<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoReport extends Model
{
    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }
    public function fotoPreview()
    {
        return $this->hasOne(Foto::class)->select(['file', 'foto_report_id']);
    }
    public function restType()
    {
        return $this->belongsTo(RestType::class);
    }
}
