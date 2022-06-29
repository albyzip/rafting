<?php

namespace App\Http\Controllers;

use App\Models\OurBand;
use Illuminate\Http\Request;

class OurBandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OurBand::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OurBand  $ourBand
     * @return \Illuminate\Http\Response
     */
    public function show(OurBand $ourBand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OurBand  $ourBand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OurBand $ourBand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OurBand  $ourBand
     * @return \Illuminate\Http\Response
     */
    public function destroy(OurBand $ourBand)
    {
        //
    }
}
