<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function show() {
        $show = Option::get();
        dd($show);
    }

    public function detail($request) {
        $detail = Option::find($request);
        dd($detail);
    }
}
