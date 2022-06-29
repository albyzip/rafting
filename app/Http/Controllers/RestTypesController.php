<?php

namespace App\Http\Controllers;

use App\Models\RestTypes;
use Illuminate\Http\Request;

class RestTypesController extends Controller
{
    public function show() {
        $show = RestTypes::get();
        dd($show);
    }

    public function detail($request) {
        $detail = RestTypes::find($request);
        dd($detail);
    }
}
