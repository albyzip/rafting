<?php

namespace App\Http\Controllers;

use App\Models\SiteOptions;
use Illuminate\Http\Request;

class SiteOptionsController extends Controller
{
    public static function show($request)
    {
        $show = SiteOptions::where('group', $request)->get(['name_en', 'group', 'value']);
        foreach($show as $items) {
            $options[$items['name_en']] = $items['value'];
        };
        return $options;
    }
}
