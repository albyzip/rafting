<?php

namespace App\Http\Controllers;

use App\Helpers\BotFoto;
use App\Helpers\BotHelper;
use App\Helpers\BotKeyboard;
use App\Helpers\BotMenu;
use App\Helpers\BotMsg;
use App\Models\FotoReport;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Barryvdh\DomPDF\Facade\Pdf;
class MainController extends Controller
{
    public function handle()
    {
        $update = Telegram::getWebhookUpdates();
        Telegram::commandsHandler(true);
        if ($update->isType('callback_query')) {
            $route = explode('_', $update->getCallbackQuery()->data);
            if ($update->getCallbackQuery()->data == 'mainmenu') {
                BotMenu::mainMenu($update);
            } elseif ($update->getCallbackQuery()->data == 'addCert') {
                BotMenu::addCert($update);
            }
              elseif ($update->getCallbackQuery()->data == 'fotoreports') {
                $this->fotoreports($update->getCallbackQuery(), $update->getCallbackQuery()->data);
            } elseif (count($route) == '1') {
                $this->show($update->getCallbackQuery(), $update->getCallbackQuery()->data);
            } elseif (count($route) == '2') {
              if ($route['0']  == 'p') {
                  $this->certificate($update->getCallbackQuery(), $route['1']);
              } elseif ($route['0']  == 'fotoreports') {
                  $this->fotos($update->getCallbackQuery(), $route['1']);
              } else {
                    $this->detail($update->getCallbackQuery(), $route['1'], false);
                }
            } elseif (count($route) == '3') {
                if ($route['1']  == 'fotoreports') {
                    $this->fotoReports($update->getCallbackQuery(), $route['1']);
                } else {
                    $this->show($update->getCallbackQuery(), $route['1']);
                }
            }
        }
    }
    function show($update, $route)
    {
        $list = RestController::showRestByTypeName($route);
        if ($list->count() > 1) {
            $reply_markup = BotKeyboard::makeButtons($list, 'name', 'id', $route);
            $reply_markup = BotKeyboard::mainMenuBtn($reply_markup);
            $reply_markup = BotKeyboard::prepareKeyboard($reply_markup);
            $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
            return BotMsg::editMessage($update, $reply_markup);
        } elseif ($list->count() == 1) {
            $list->toArray();
            $this->detail($update, $list[0]['id'], true);
        }
    }
    function fotoReports($update, $route)
    {
        $list = FotoReportController::show();
        if ($list->count() > 1) {
            $reply_markup = BotKeyboard::makeButtons($list, 'name', 'id', $route);
            $reply_markup = BotKeyboard::mainMenuBtn($reply_markup);
            $reply_markup = BotKeyboard::prepareKeyboard($reply_markup);
            $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
            return BotMsg::editMessage($update, $reply_markup);
        } elseif ($list->count() == 1) {
            $list->toArray();
            $this->fotos($update, $list[0]['id'], true);
        }
    }
    function certificate($update, $count)
    {
      $characters = '123456789ABCEHKMPTX';
      $certificteNumber = '';
      for ($i = 0; $i < 5; $i++) {
          $index = rand(0, strlen($characters) - 1);
          $certificteNumber .= $characters[$index];
      }
      $viewhtml = \View::make('components/a', ['count'=> $count, 'certificate' => $certificteNumber])->render();
      $pdf = PDF::loadHtml($viewhtml);
      $pdf->setPaper('A5', 'landscape');
      $pdf->render();
      $output = $pdf->output();
      file_put_contents('certificates/'.$certificteNumber.'.pdf', $output);
      $media[] =
          [
              "type" => "document",
              "media" => 'https://new.xn--80aaibehq4byavv4g8b.xn--p1ai'.'/certificates/'.$certificteNumber.'.pdf'
          ];
      BotMsg::sendMediaMessage($update, $media);
      $menu = BotMenuController::show();
      $reply_markup = BotKeyboard::makeButtons($menu, 'name_ru', 'name_en', null, 'type', $update->from->id);
      $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
          Telegram::sendMessage([
              'chat_id' => $update->from->id,
              'text' => 'Здравствуйте',
              'reply_markup' => $reply_markup
          ]);
    }

    function fotos($update, $id, $onlyOne)
    {
        //Make buttons
        $reply_markup = BotKeyboard::mainMenuBtn();
        if (!$onlyOne) {
            $reply_markup = BotKeyboard::backBtn($update, $reply_markup);
        }
        $reply_markup = BotKeyboard::prepareKeyboard($reply_markup);
        $reply_markup = BotKeyboard::makeKeyboard($reply_markup);

        //Get description
        $result = FotoReportController::detail($id);

        //Delete message
        BotMsg::deleteMessage($update);

        //Preparing and send fotos
        $media = BotFoto::prepareFoto($result['fotos'], $result['text']);
        $result['text'] = 'Выберите';
        BotMsg::sendMediaMessage($update, $media);
        return BotMsg::newMessage($update, $result['text'], $reply_markup);
    }

    function detail($update, $id, $onlyOne)
    {
        //Make buttons
        $reply_markup = BotKeyboard::callUsBtn();
        $reply_markup = BotKeyboard::mainMenuBtn($reply_markup);
        if (!$onlyOne) {
            $reply_markup = BotKeyboard::backBtn($update, $reply_markup);
        }
        $reply_markup = BotKeyboard::prepareKeyboard($reply_markup);
        $reply_markup = BotKeyboard::makeKeyboard($reply_markup);

        //Get description
        $result = RestController::detailDescription($id);

        //Delete message
        BotMsg::deleteMessage($update);

        //Preparing and send fotos
        if (isset($result['rest']['foto'])) {
            $media = BotFoto::prepareFoto($result['rest']['foto'], $result['text']);
            $result['text'] = 'Выберите:';
            BotMsg::sendMediaMessage($update, $media);
        }
        return BotMsg::newMessage($update, $result['text'], $reply_markup);
    }
    function test()
    {
        $list = RestController::showRestByTypeName('raftings');

        $reply_markup = BotKeyboard::makeButtons($list, 'name', 'id', 'raftings');
        $reply_markup = BotKeyboard::mainMenuBtn($reply_markup);
        $reply_markup = BotKeyboard::prepareKeyboard($reply_markup);
        // $reply_markup = BotKeyboard::makeKeyboard($reply_markup);
        dd($reply_markup);
    }
}
