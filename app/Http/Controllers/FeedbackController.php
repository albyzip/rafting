<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class FeedbackController extends Controller
{
    function phoneFormat($phone)
    {
        $phone = trim($phone);

        $res = preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ),
            array(
                '+7$2$3$4$5',
                '+7$2$3$4$5',
                '+7$2$3$4$5',
                '+7$2$3$4$5',
                '+7$2$3$4',
                '+7$2$3$4',
            ),
            $phone
        );

        return $res;
    }
    public function send(Request $request)
    {
        if ($request->form == 'sendReview') {
            $rating = '';
            for ($i = 0; $i < $request->rating; $i++) {
                $rating .= '⭐';
            }
            $review = new Review();
            $review->name = $request->name;
            $review->rating = $request->rating;
            $review->text = $request->review;
            $review->save();
            Telegram::sendMessage([
                'chat_id' => '978249214',
                'text' => 'Новый отзыв:' . PHP_EOL . 'Имя: <b>' . $request->name . '</b>' . PHP_EOL . 'Оценка: <b>' . $rating . '</b>' . PHP_EOL . 'Текст отзыва: <b>' . $request->review . '</b>' . PHP_EOL,
                'parse_mode' => 'HTML',
            ]);
        } elseif ($request->form == 'scheduleRafting') {
            Telegram::sendMessage([
                'chat_id' => '978249214',
                'text' => 'Запрос с сайта:' . PHP_EOL . 'Имя: <b>' . $request->name . '</b>' . PHP_EOL . 'Номер телефона: <b>' . $this->phoneFormat($request->tel) . '</b>' . PHP_EOL . 'Дата сплава: <b>' . $request->date . '</b>' . PHP_EOL,
                'parse_mode' => 'HTML',
            ]);
        } elseif ($request->form == 'bookRest') {
            Telegram::sendMessage([
                'chat_id' => '978249214',
                'text' => 'Запрос с сайта:' . PHP_EOL . 'Имя: <b>' . $request->name . '</b>' . PHP_EOL . 'Номер телефона: <b>' . $this->phoneFormat($request->tel) . '</b>' . PHP_EOL . 'Забронировать: <b>' . $request->rest . '</b>' . PHP_EOL,
                'parse_mode' => 'HTML',
            ]);
        }
    }
}
