<?php

namespace App\Http\Controllers;

use App\Models\TransaksiIuran;
use App\Models\Warga;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        
        return view('home.index', [
            'title' => 'Halaman utama',
            'menu' => 'utama',
            'submenu' => 'utama',
        ]);
    }

    public function getIuran(){
        $iuran = Warga::get();
        if (count($iuran) > 0) {
            return response()->json(['statusCode' => 200, 'data' => $iuran]);
        } else {
            return response()->json(['statusCode' => 400, 'message' => "data tidak ditemukan"], 400);
        }
        
    }
}
