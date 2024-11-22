<?php

namespace App\Http\Controllers;

use App\Models\KategoriIuran;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    
    public function index()
    {
        return view('kategori.index', [
            'title' => 'Kategori',
            'menu' => 'kategori',
            'submenu' => 'kategori'
        ]);
    }

    public function json()
    {
        $columns = ['id', 'nama_kategori', 'nominal'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = KategoriIuran::select('id', 'nama_kategori', 'nominal');

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('nama_kategori like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nominal like ? ', ['%' . request()->input("search.value") . '%']);
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

    
    public function validation($request)
    {
        $request->validate([
            'nama_kategori' =>'required|max:255',
            'nominal' =>'required',
        ]);
    }

    
    public function store(Request $request)
    {
        $this->validation($request);
        $kategori = new KategoriIuran();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->nominal = preg_replace('/[^0-9]/', '', $request->nominal);
        $kategori->save();
        return response()->json(['statusCode' => 200, 'message' => 'Data berhasil disimpan']);
    }

    
    public function update(Request $request, string $id)
    {
        $this->validation($request);
        try {
            $kategori = KategoriIuran::findOrFail($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->nominal = preg_replace('/[^0-9]/', '', $request->nominal);
            $kategori->save();
            return response()->json(['statusCode' => 200, 'message' => 'Data berhasil diupdate']);
        } catch (\Throwable $th) {
            return response()->json(['statusCode' => 404, 'message' => 'Data tidak ditemukan'], 400);
        }
    }

    
    public function destroy(string $id)
    {
        try {
            $kategori = KategoriIuran::findOrFail($id);
            $kategori->delete();
            return response()->json(['statusCode' => 200,'message' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['statusCode' => 404, 'message' => 'Data tidak ditemukan'], 400);
        }
    }
}
