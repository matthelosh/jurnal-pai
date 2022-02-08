<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DashController extends Controller
{
    public function index(Request $request)
    {
        $route = Route::current();
        $user = User::find($request->id);
        $name = $route->action['as'];
        $names = explode('.', $name);
        $view = '';
        for ($i=0; $i < count($names); $i++) {
            $view .= ".".ucfirst($names[$i]);
        }
        $view = str_replace('.', '/',$view);
        // dd($view);
        return Inertia::render('Dashboard/'.ltrim($view, $view[0]));
    }
}
