<?php

namespace App\Http\Controllers;

use App\Services\PerangkatFacade;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    public function get(Request $request)
    {
        $data = null;
        switch($request->query('tipe')) 
        {
            case "kd":
                return $data = ['kds' => PerangkatFacade::getKd($request->query('tingkat'))];
                break;
            case "pembelajaran":
                return $data = ['pembelajarans' => PerangkatFacade::getPbl()];
                break;

        }

        return response()->json(['success' => true, $data], 200);
    }


    public function storePbl(Request $request)
    {
        return response()->json(['success' => true, 'pembelajaran' => PerangkatFacade::storePbl($request->all())], 200);
    }
}
