<?php

namespace App\Helpers;

use App\Http\Controllers\BotMenuController;
use Illuminate\Support\Arr;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotMenu
{
    public static function mainMenu($update)
    {
        $menu = BotMenuController::show();
        if (!$update->isType('callback_query')) {
          $reply_markup = BotKeyboard::makeButtons($menu, 'name_ru', 'name_en', null, 'type', $update->getMessage()->from->id);
          $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->from->id,
                'text' => 'Здравствуйте',
                'reply_markup' => $reply_markup
            ]);
        } else {
          $reply_markup = BotKeyboard::makeButtons($menu, 'name_ru', 'name_en', null, 'type', $update->getCallbackQuery()->from->id);
          $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
            Telegram::editMessageText([
                'chat_id' =>  $update->getCallbackQuery()->from->id,
                'message_id' => $update->getCallbackQuery()->message->message_id,
                'text' => 'Выберите:',
                'reply_markup' => $reply_markup
            ]);
        }
    }

    public static function addCert($update)
    {

        $reply_markup = BotKeyboard::makeCertificate($update->getMessage()->from->id);
        $reply_markup = BotKeyboard::makeKeyboard($reply_markup);

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
                'text' => 'Сколько человек:',
                'reply_markup' => $reply_markup
            ]);
        }
    }

}
