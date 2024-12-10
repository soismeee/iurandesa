<?php

namespace App\Http\Controllers;

use App\Models\TransaksiIuran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $wargaBelumBayar = Warga::whereDoesntHave('transaksiIuran', function ($query) use ($bulanIni, $tahunIni) {
            $query->whereMonth('tanggal_iuran', $bulanIni)
                ->whereYear('tanggal_iuran', $tahunIni);
        })->get();

        $wargaSudahBayar = Warga::whereHas('transaksiIuran', function ($query) use ($bulanIni, $tahunIni) {
            $query->whereMonth('tanggal_iuran', $bulanIni)
                  ->whereYear('tanggal_iuran', $tahunIni);
        })->get();

        if (count($wargaBelumBayar) > 0) {
            return response()->json(['statusCode' => 200, 'belum' => $wargaBelumBayar, 'sudah' => $wargaSudahBayar]);
        } else {
            return response()->json(['statusCode' => 400, 'message' => "Bulan ini warga tertib iuran"], 400);
        }
    }

    public function getDashbaord(){
        $data = [
            'warga' => Warga::count(),
            'iuransdini' => TransaksiIuran::whereYear('tanggal_iuran', date('Y'))->sum('nominal'),
            'iuranblini' => TransaksiIuran::whereMonth('tanggal_iuran', date('m'))->whereYear('tanggal_iuran', date('Y'))->sum('nominal'),
            'iuranbllalu' => TransaksiIuran::whereMonth('tanggal_iuran', date('m', strtotime('-1 month')))->whereYear('tanggal_iuran', date('Y'))->sum('nominal'),
        ];

        return response()->json(['statusCode' => 200, 'data' => $data]);
    }
}
