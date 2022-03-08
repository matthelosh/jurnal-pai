<?php

namespace App\Http\Controllers;

use App\Facades\Prota;
use Illuminate\Http\Request;

class ProtaController extends Controller
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

    public function getByTingkat($semester, $tingkat)
    {
        try {
            return response()->json(['success' => true, 'protas' => Prota::getByTingkat($semester, $tingkat)], 200);
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
     * @param  \App\Models\Prota  $prota
     * @return \Illuminate\Http\Response
     */
    public function show(Prota $prota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prota  $prota
     * @return \Illuminate\Http\Response
     */
    public function edit(Prota $prota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prota  $prota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prota $prota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prota  $prota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prota $prota)
    {
        //
    }
}
