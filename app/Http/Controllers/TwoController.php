<?php

namespace App\Http\Controllers;

use App\Models\BotMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TwoController extends Controller
{
    public function show()
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->setOneTimeKeyboard(true)
            ->row(
                Keyboard::inlineButton([
                    'text' => 'Сплавы',
                    'callback_data' => 'raftings'
                ]),
                Keyboard::inlineButton([
                    'text' => 'Банька',
                    'callback_data' => 'callback_from_testbtn'
                ])
            )
            ->row(
                Keyboard::inlineButton([
                    'text' => 'Фотоотчеты',
                    'callback_data' => 'foto_reports'
                ])
            )
            ->row(
                Keyboard::inlineButton([
                    'text' => 'Позвонить нам',
                    'callback_data' => 'call_us'
                ]),
                Keyboard::inlineButton([
                    'text' => 'Написать нам',
                    'callback_data' => 'message_us'
                ])
            );

        $menu = BotMenu::get(['name_ru', 'name_en', 'sort', 'type']);
        $menu = $menu->groupBy('sort')->toArray();
        foreach ($menu as $key => $items) {
            foreach ($items as $item) {
                $button[$key][] = [
                    'text' => $item['name_ru'],
                    $item['type'] => $item['name_en']
                ];
            }
        }
        dd($button);
    }
}
