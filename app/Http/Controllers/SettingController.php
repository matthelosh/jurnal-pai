<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SettingService;

class SettingController extends Controller
{
    private $settingService;
    public function __construct(SettingService $service)
    {
        $this->settingService = $service;
    }
    public function periode(Request $request)
    {
        try {
            return response()->json(['success' => true, 'periodes' => $this->settingService->periode()], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function StatusPeriode(Request $request)
    {
        try {
            return response()->json(['success' => true, 'periode' => $this->settingService->statusPeriode($request->query('id'), $request->query('status'))], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    public function storePeriode(Request $request)
    {
        try {
            return response()->json(['success' => true, 'periode' => $this->settingService->storePeriode($request->all())],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
