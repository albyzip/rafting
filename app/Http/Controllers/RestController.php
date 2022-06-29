<?php

namespace App\Http\Controllers;

use App\Models\Rest;
use App\Models\RestType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class RestController extends Controller
{
    public function show()
    {
        return Rest::get();
    }
    public static function showPreview()
    {
        $show = Rest::with(['options', 'options.options'])->get(['name', 'id'])->toArray();
        foreach ($show as $key => $list) {
            $price[$key]['name'] = $list['name'];
            $price[$key]['id'] = $list['id'];
            foreach ($list['options'] as $items) {
                if ($items['options']['name'] == 'Цена' || $items['options']['name'] == 'Цена для детей' || $items['options']['name'] == 'Возраст детей') {
                    $price[$key]['price'][$items['options']['name']] = str_replace(' руб', '', $items['value']);
                } elseif ($items['options']['name'] == 'Фото') {
                } else {
                    $price[$key]['options'][$items['options']['name']] = $items['value'];
                }
            }
        }
        return $price;
    }
    public static function test()
    {
          $viewhtml = \View::make('components/a')->render();
          $pdf = PDF::loadHtml($viewhtml);
          $pdf->setPaper('A5', 'landscape');
          $pdf->render();
          $output = $pdf->output();
          return file_put_contents('certificates/A5HM1.pdf', $output);
    }
    public static function detailDescription($request)
    {
        $list = Rest::where('id', $request)->with(['options', 'options.options'])->first();
        $list = $list->toArray();
        $rest['name'] = $list['name'];

        if (isset($list['description'])) {
            $rest['description'] = $list['description'];
        }
        foreach ($list['options'] as $key => $items) {
            if ($items['options']['name'] == 'Фото') {
                $rest['foto'][] = $items['value'];
            } elseif ($items['options']['name'] == 'Цена' || $items['options']['name'] == 'Цена для детей' || $items['options']['name'] == 'Возраст детей') {
                $rest['price'][$items['options']['name']] = $items['value'];
            } else {
                $rest['options'][$items['options']['name']] = $items['value'];
            }
        }
        $text = '<u>' . $rest['name'] . '</u>' . PHP_EOL;

        if (isset($rest['options'])) {
            $rest['options'] = Arr::sort($rest['options']);
            foreach ($rest['options'] as $key => $item) {
                $text .= '<i>' . $key . ': ' . $item . '</i>' . PHP_EOL;
            }
        }
        if (isset($rest['price'])) {
            $rest['price'] = Arr::sort($rest['price']);
            foreach ($rest['price'] as $key => $item) {
                $text .= '<b>' . $key . ': ' . $item . '</b>' . PHP_EOL;
            }
        }
        if (isset($rest['description'])) {
            $text .= $rest['description'] . PHP_EOL;
        }

        return compact('rest', 'text');
    }
    public static function detail($request)
    {
        $list = Rest::where('id', $request)->with(['options', 'options.options'])->first();
        $list = $list->toArray();

        $rest['id'] = $list['id'];
        $rest['name'] = $list['name'];

        if (isset($list['description'])) {
            $rest['description'] = $list['description'];
        }
        foreach ($list['options'] as $items) {
            if ($items['options']['name'] == 'Фото') {
                $rest['foto'][$items['id']] = $items['value'];
            } elseif ($items['options']['name'] == 'Цена' || $items['options']['name'] == 'Цена для детей' || $items['options']['name'] == 'Возраст детей') {
                $rest['price'][$items['options']['name']] = $items['value'];
            } else {
                $rest['options'][$items['options']['name']] = $items['value'];
            }
        }

        return $rest;
    }

    public static function showRestByTypeName($typeName)
    {
        $restType = RestType::where('name_en', $typeName)->first();
        return Rest::where('rest_types_id', $restType->id)->get(['name', 'id']);
    }
}
