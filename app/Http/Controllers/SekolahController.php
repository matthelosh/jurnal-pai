<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Services\SekolahService;

class SekolahController extends Controller
{
    private $sekolahService;

    public function __construct(SekolahService $service)
    {
        $this->sekolahService = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $sekolahs = $this->sekolahService->index();
            return response()->json(['success' => true, 'sekolahs' => $sekolahs], 200);
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
            $sekolah = $this->sekolahService->store($request->all());
            return response()->json(['success' => true, 'sekolah' => $sekolah], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show($npsn)
    {
        try {
            return response()->json(['success' => true, 'sekolah' => Sekolah::where('npsn', $npsn)->first()], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)
    // {
    //     try {
    //         $sekolah = $this->sekolahService->update($request->all());
    //         return response()->json(['success' => true, 'sekolah' => $sekolah], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}
