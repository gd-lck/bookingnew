<?php

namespace App\Http\Controllers;

use App\Models\Profil_perusahaan;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $perusahaan = Profil_perusahaan::first(); // Ambil data perusahaan pertama
        return view('welcome', compact('perusahaan'));
    }

}
