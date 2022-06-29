<?php

namespace App\Helpers;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotMsg
{
    public static function editMessage($update, $reply_markup)
    {
        Telegram::editMessageText([
            'chat_id' =>  $update->from->id,
            'message_id' => $update->message->message_id,
            'text' => 'Выберите:',
            'reply_markup' => $reply_markup
        ]);
    }
    public static function newMessage($update, $text, $reply_markup)
    {
        Telegram::sendMessage([
            'chat_id' =>  $update->from->id,
            'text' => $text,
            'parse_mode' => 'Html',
            'reply_markup' => $reply_markup
        ]);
    }
    public static function deleteMessage($update)
    {
            Telegram::deleteMessage([
                'chat_id' =>  $update->from->id,
                'message_id' => $update->message->message_id
            ]);
    }
    public static function sendMediaMessage($update, $media)
    {
            Telegram::sendMediaGroup([
                'chat_id' =>  $update->from->id,
                'media' => json_encode($media)
            ]);
    }
}
