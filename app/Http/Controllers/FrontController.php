<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    public function home()
    {
        return Inertia::render('Front',['pageTitle' => 'Beranda'])->withViewData(['pageTitle' => 'Beranda','pageDescription' => 'Deskripsi Laman']);
    }
    public function about()
    {
        $description = 'Laman tentang Jurnal PAI Kecamatan Wagir';
        return Inertia::render('About',['pageTitle' => 'Tentang Jurnal'])->withViewData(['pageTitle' => 'Tentang Jurnal','pageDescription' => $description]);
    }

    public function login()
    {
        return Inertia::render('Auth/Login')->withViewData(['pageTitle' => 'Login | Jurnal PAI Wagir', 'description' => 'Laman Login Jurnal Pembelajaran PAI Kecamatan Wagir']);
    }
}
