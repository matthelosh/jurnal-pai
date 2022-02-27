<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return response()->json(['uccess' => true, 'menus' =>$menus], 200);
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
            $menu = Menu::updateOrCreate(
                [
                    'id' => $request->id ?? null,
                ],
                [
                    'label'=>$request->label,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'role' => implode(",", $request->role)
                ]
            );
            return response()->json(['success' => true, 'menu' => $menu], 200);
        } catch (\Throwable $th) {
            return response()->json(['successs' => false, 'msg' => $th->getMessage()], 500);
        }
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, $id)
    {
        try {
            $menu = $menu::destroy($id);
            return response()->json(['success' => true, 'menu' =>$menu], 200);
        } catch (\Throwable $th) {
            return response()->json(['successs' => false, 'msg' => $th->getMessage()], 500);
        }
    }
}
