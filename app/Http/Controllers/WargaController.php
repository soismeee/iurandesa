<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    
    public function index()
    {
        return view('warga.index', [
            'title' => 'Warga',
            'menu' => 'Warga',
            'submenu' => 'Warga',
        ]);
    }

    public function getWarga(){
        $warga = Warga::select('id', 'no_urut', 'nama_lengkap')->get();
        if (count($warga) > 0) {
            return response()->json(['statusCode' => 200, 'data' => $warga]);
        } else {
            return response()->json(['statusCode' => 400, 'message' => "Tidak ada data warga di database"], 400);
        }
    }

    
    public function json()
    {
        $columns = ['id', 'no_urut', 'nama_lengkap', 'alamat', 'no_hp'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Warga::select('id', 'no_urut', 'nama_lengkap', 'alamat', 'no_hp');

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('no_urut like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nama_lengkap like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('alamat like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('no_hp like ? ', ['%' . request()->input("search.value") . '%']);
            });
        }

        $recordsFiltered = $data->get()->count();
        $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy, request()->input("order.0.dir"))->get();
        $recordsTotal = $data->count();
        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function validation($request){
        $request->validate([
            'no_urut' => 'required',
            'nama_lengkap' => ['required','string','max:255'],
            'alamat' => ['required','string'],
            'no_hp' => ['required'],
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validation($request);
        Warga::create($request->all());
        return response()->json(['statusCode' => 200, 'message' => "Data berhasil ditambahkan"]);
    }
    
    
    public function update(Request $request, string $id)
    {
        $this->validation($request);
        try {
            $warga = Warga::findOrFail($id);
            $warga->nama_lengkap = $request->nama_lengkap;
            $warga->no_urut = $request->no_urut;
            $warga->no_hp = $request->no_hp;
            $warga->alamat = $request->alamat;
            $warga->update();
            return response()->json(['statusCode' => 200, 'message' => "Data berhasil diubah"]);
        } catch (\Throwable $th) {
            return response()->json(['statusCode' => 400, 'message' => "Data tidak berhasil diubah"], 400);
        }
    }

    
    public function destroy(string $id)
    {
        //
    }
}
