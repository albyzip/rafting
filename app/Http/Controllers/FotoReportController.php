<?php

namespace App\Http\Controllers;

use App\Models\FotoReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FotoReportController extends Controller
{
    public static function show() {
        $fotoReports = FotoReport::get(['id','created_at as name']);
        foreach ($fotoReports as $item) {
            $date = Carbon::parse($item->name)->locale('ru');
            $item->name = $date->isoFormat('D MMMM YYYY'.'г.');
        }
        return $fotoReports;
    }
    public static function showWithPreview() {
        $fotoReports = FotoReport::with('fotoPreview')->get(['id','created_at as name']);
        foreach ($fotoReports as $item) {
            $date = Carbon::parse($item->name)->locale('ru');
            $item->name = $date->isoFormat('D MMM YYYY'.'г.');
        }
        return $fotoReports->toArray();
    }
    public static function detail($id) {
        $fotoReports = FotoReport::where('id', $id)->with('fotos:foto_report_id,file')->first();
        $date = Carbon::parse($fotoReports->created_at)->locale('ru');
        $text = $date->isoFormat('D MMMM YYYY'.'г.');
        foreach($fotoReports['fotos'] as $key => $item) {
            $fotos[$key]['src'] = $item['file'];
            $fotos[$key]['thumb'] = $item['file'];
        }
        return $fotos;

    }
}
