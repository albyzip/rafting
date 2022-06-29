<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public static function show() {
        return Review::where('is_published', '1')->get();
    }
}
