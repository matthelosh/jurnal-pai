<?php

namespace App\Http\Controllers;

use App\Facades\Kaldik;
use Illuminate\Http\Request;

class KaldikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function byTapel($tapel)
    {
       try {
           return response()->json(['success' => true, 'kaldiks' => Kaldik::byTapel($tapel)], 200);
       } catch (\Throwable $th) {
           return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $kaldik = Kaldik::store($request->all());
            return response()->json(['success' => true, 'kaldik' => $kaldik], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kaldik  $kaldik
     * @return \Illuminate\Http\Response
     */
    public function show(Kaldik $kaldik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kaldik  $kaldik
     * @return \Illuminate\Http\Response
     */
    public function edit(Kaldik $kaldik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kaldik  $kaldik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kaldik $kaldik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kaldik  $kaldik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kaldik $kaldik)
    {
        //
    }
}
