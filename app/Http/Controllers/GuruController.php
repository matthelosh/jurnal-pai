<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Services\GuruService;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuruService $guruService)
    {
        try {
            return response()->json(['success' => true, 'gurus' => $guruService->index()], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, GuruService $guruService)
    {
        try {
            $guru = $guruService->store($request->all());
            return response()->json(['success' => true, 'guru' => $guru], 200);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function impor(Request $request, GuruService $guruService)
    {
        try {
            $impor = $guruService->impor($request->all());
            return response()->json(['success' => true, 'guru' => $impor], 200);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
    public function createAccount(Request $request, GuruService $guruService)
    {
        try {
            $impor = $guruService->createAccount($request->all());
            return response()->json(['success' => true, 'guru' => $impor], 200);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }



   public function destroySome(Request $request, GuruService $guruService)
   {
        try {
            $hapus = $guruService->destroySome($request->all());
            return response()->json(['success' => true, 'hapus' => $hapus], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
   }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, GuruService $guruService, $id)
    {
        try {
            $hapus = $guruService->destroy($id);
            return response()->json(['success' => true, 'hapus' => $hapus], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
