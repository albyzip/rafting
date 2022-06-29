<?php

namespace App\Http\Controllers;

use App\Models\Rest;
use App\Models\RestOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RestOptionController extends Controller
{
    public function deleteFoto(Request $request)
    {
        $foto = RestOption::where('id', $request->id)->first();
        $file = 'images/rests/'.$foto->value;
        if (File::exists($file)) {
            File::delete($file);
        };
        $foto->delete();
    }

    public function uploadFotos(Request $request)
    {
        $rest = Rest::where('id', $request->header('REST_ID'))->first();
        $date = Carbon::now()->timestamp;
        foreach ($request->file('files') as $item) {
        $foto = new RestOption();
            $nameFoto = '/images/rests/'.Str::slug($rest->name) . '-' . crc32($item->getClientOriginalName() . $date) . '.' . $item->getClientOriginalExtension();
            $item->move('images/rests', $nameFoto);
            $foto->rest_id = $request->header('rest-id');
            $foto->options_id = '6';
            $foto->value = $nameFoto;
            $foto->save();
            $arr[$foto->id ] = $nameFoto;
        }
        return $arr;
    }
}
