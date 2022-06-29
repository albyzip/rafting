<?php

namespace App\Http\Controllers;

use App\Models\BotMenu;
use Illuminate\Http\Request;

class BotMenuController extends Controller
{
    public static function show()
    {
        $menu = BotMenu::orderBy('sort')->get(['name_ru', 'name_en', 'sort', 'type']);
        return $menu->toArray();
    }
}
