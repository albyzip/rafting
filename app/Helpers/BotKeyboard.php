<?php

namespace App\Helpers;

use App\Models\BotMenu;
use Illuminate\Support\Arr;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotKeyboard
{

    public static function makeButtons($list, $name, $url, $route, $type = null, $admin = null)
    {
        foreach ($list as $item) {
            if (!isset($type)) {
                $buttons[] = [
                    'text' => $item[$name],
                    'callback_data' => $route . '_' . $item[$url]
                ];
            } else {
                $buttons[] = [
                    'text' => $item[$name],
                    $item[$type] => $item[$url]
                ];
            }
        };
        if ($admin == '328100017' || $admin == '978249214') {
          $buttons[] = [
            'text' => 'Выпустить сертификат',
            'callback_data' => 'addCert'
          ];
        }
        $buttons = array_chunk($buttons, 2);
        return $buttons;
    }
    public static function makeCertificate($admin = null)
    {
          for ($i = 1; $i <= 10; $i++) {
                  $buttons[] = [
                      'text' => $i,
                      'callback_data' => 'p_'.$i
                  ];
          };
          $buttons = array_chunk($buttons, 3);

        return $buttons;
    }
    public static function mainMenuBtn($buttons = [])
    {
        array_push($buttons, ['back' => [
            'text' => 'Главное меню',
            'callback_data' => 'mainmenu'
        ]]);
        return $buttons;
    }
    public static function callUsBtn($buttons = [])
    {
        array_push($buttons, ['callUs' => [
            'text' => 'Забронировать',
            'url' => 'https://new.рафтингадыгея.рф/79181286768'
        ]]);
        return $buttons;
    }

    public static function backBtn($update, $buttons = [])
    {
        $route = explode('_', $update->data);
        array_pop($route);
        $route = implode('_',$route);
        array_push($buttons, ['back' => [
            'text' => 'Назад',
            'callback_data' => 'back_' . $route . '_' . $update->message->message_id
        ]]);
        return $buttons;
    }
    public static function prepareKeyboard($btns) {

        foreach ($btns as $items) {
            foreach ($items as $key => $item) {
                if ($key === 'back' || $key === 'callUs') {
                    $buttons[] =  $item;
                } else {
                    $buttons[] =  $item;
                }
            }

        }
        $buttons = array_chunk($buttons, 2);
        return $buttons;
    }
    public static function makeKeyboard($buttons)
    {
        return Keyboard::make([
            'inline_keyboard' =>  $buttons,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }
}
