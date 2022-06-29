<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    public function delete(Request $request) {
        Foto::where('id', $request->id)->delete();
    }
}
