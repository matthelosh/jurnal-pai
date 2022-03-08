<?php

namespace App\Http\Controllers;

use App\Models\Kd;
use Illuminate\Http\Request;

class KdController extends Controller
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

    public function getByIds(Request $request)
    {
        try {
            $tingkat = $request->query('tingkat');
            $kds = Kd::where('tingkat', $request->query('tingkat'))->whereIn('kode_kd', $request->kds)->with('indikators', function($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            })->get();
            return response()->json(['success' => true, 'kds' => $kds], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function show(Kd $kd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function edit(Kd $kd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kd $kd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kd $kd)
    {
        //
    }
}
