<?php

namespace App\Helpers;

use App\Models\BotMenu;
use Illuminate\Support\Arr;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotFoto
{
    public static function prepareFoto($fotos, $text)
    {
        $count = count($fotos);
        foreach ($fotos as $key => $item) {
            if ($count == $key + 1) {
                $media[] =
                    [
                        "type" => "photo",
                        //"media" => $item,
                        "media" => 'https://new.xn--80aaibehq4byavv4g8b.xn--p1ai'.$item,
                        'parse_mode' => 'HTML',
                        "caption" => $text
                    ];
            } else {
                $media[] =
                    [
                        "type" => "photo",
                        "media" => 'https://new.xn--80aaibehq4byavv4g8b.xn--p1ai'.$item
                        //"media" => $item
                    ];
            }
        }
        return $media;
    }

}
