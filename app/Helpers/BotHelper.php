<?php

namespace App\Helpers;

use App\Models\BotMenu;
use Illuminate\Support\Arr;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotHelper
{
    public function make_buttons($list, $name, $url, $route)
    {
        foreach ($list as $item) {
            $buttons[] = [
                'text' => $item[$name],
                'callback_data' => $route . '_' . $item[$url]
            ];
        };
        $buttons = array_chunk($buttons, 2);
        array_push($buttons, [[
            'text' => 'Главное меню',
            'callback_data' => 'mainmenu'
        ]]);

        return $this->make_keyboard($buttons);
    }
    public function make_backbutton($update, $route)
    {
        $route = explode('_', $route);
        if ($route['1'] == 'detail') {

            $buttons[] = [[
                'text' => 'Назад',
                'callback_data' => 'back_' . $route['0'] . '_' . $update->message->message_id
            ], [
                'text' => 'Главное меню',
                'callback_data' => 'mainmenu'
            ]];
            $buttons = Arr::prepend($buttons, [[
                'text' => 'Забронировать',
                'callback_data' => 'call_us'
            ]]);
        } else {
            $buttons[][] = [
                'text' => 'Назад',
                'callback_data' => 'back_' . $route['0'] . '_' . $update->message->message_id
            ];
        }

        return $this->make_keyboard($buttons);
    }


    public static function main_menu($update)
    {
        $menu = BotMenu::get(['name_ru', 'name_en', 'sort', 'type']);
        $menu = $menu->groupBy('sort')->toArray();
        foreach ($menu as $key => $items) {
            foreach ($items as $item) {
                $button[$key][] = [
                    'text' => $item['name_ru'],
                    $item['type'] => $item['name_en']
                ];
            }
        };
        $keyboard = array_values($button);
        $reply_markup = Keyboard::make([
            'inline_keyboard' =>  $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        if (!$update->isType('callback_query')) {
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->from->id,
                'text' => 'Здравствуйте',
                'reply_markup' => $reply_markup
            ]);
        } else {
            Telegram::editMessageText([
                'chat_id' =>  $update->getCallbackQuery()->from->id,
                'message_id' => $update->getCallbackQuery()->message->message_id,
                'text' => 'Выберите:',
                'reply_markup' => $reply_markup
            ]);
        }
    }


    public function make_keyboard($buttons)
    {
        return Keyboard::make([
            'inline_keyboard' =>  $buttons,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }
    public function edit_message($update, $reply_markup)
    {
        Telegram::editMessageText([
            'chat_id' =>  $update->from->id,
            'message_id' => $update->message->message_id,
            'text' => 'Выберите:',
            'reply_markup' => $reply_markup
        ]);
    }
}
