<?php

namespace App\Http\Controllers;

use App\Models\KategoriIuran;
use App\Models\TransaksiIuran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class IuranController extends Controller
{
    public function index(){
        return view('iuran.index', [
            'title' => 'Daftar iuran',
            'menu' => 'iuran',
            'submenu' => 'iuran',
            'kategori' => KategoriIuran::select('nama_kategori')->get(),
            'tahun' => $this->rangeTahun(),
            'bulan' => $this->listBulan()
        ]);
    }

    public function rangeTahun(){
        $tahun_sekarang = Carbon::now()->year;
        // Membuat array tahun dari 10 tahun yang lalu hingga 10 tahun ke depan
        $tahun_range = range($tahun_sekarang + -1, $tahun_sekarang - 4);

        return $tahun_range;
    }

    public function jsonAll()
    {
        $columns = ['id', 'kategori_iuran', 'bulan', 'tahun', 'nominal', 'tanggal_iuran'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiIuran::with('warga')->select('id', 'warga_id','kategori_iuran', 'bulan', 'tahun', 'nominal', 'tanggal_iuran', 'created_at')
        ->whereYear('created_at', request('tahun'))
        ->orderBy('created_at', 'desc');

        if(request('kategori_iuran') !== "All"){
            $data = $data->where('kategori_iuran', request('kategori_iuran'));
        }
        if(request('bulan') !== "All"){
            $data = $data->where('bulan', request('bulan'));
        }

        if (request()->input("search.value")) {
            $searchValue = request()->input("search.value");
            $data = $data->where(function ($query) use ($searchValue){
                $query->whereRaw('kategori_iuran like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('bulan like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('tahun like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nominal like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereHas('warga', function ($q) use ($searchValue) {
                        $q->where('nama_lengkap', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        $recordsFiltered = $data->get()->count();
        $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy, request()->input("order.0.dir"))->get();
        $recordsTotal = $data->count();
        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'kategori_iuran' => request('kategori_iuran'),
            'tahun' => request('tahun'),
        ]);
    }

    public function create(){
        return view('iuran.create', [
            'title' => 'Tambah iuran',
            'menu' => 'iuran',
            'submenu' => 'iuran',
            'kategori' => KategoriIuran::select('nama_kategori', 'nominal')->get()
        ]);
    }

    public function getBulan($month){
        switch ($month) {
            case '01': $bulan = "Januari"; break;
            case '02': $bulan = "Februari"; break;
            case '03': $bulan = "Maret"; break;
            case '04': $bulan = "April"; break;
            case '05': $bulan = "Mei"; break;
            case '06': $bulan = "Juni"; break;
            case '07': $bulan = "Juli"; break;
            case '08': $bulan = "Agustus"; break;
            case '09': $bulan = "September"; break;
            case '10': $bulan = "Oktober"; break;
            case '11': $bulan = "November"; break;
            case '12': $bulan = "Desember"; break;
            default: $bulan = "Bulan"; break;
        }

        return $bulan;
    }

    public function  listBulan(){
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        return $bulan;
    }

    public function jsonhariIni()
    {
        $columns = ['id', 'kategori_iuran', 'bulan', 'tahun', 'nominal', 'tanggal_iuran'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiIuran::with('warga')->select('id', 'warga_id','kategori_iuran', 'bulan', 'tahun', 'nominal', 'tanggal_iuran', 'created_at')
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->orderBy('created_at', 'desc');

        if (request()->input("search.value")) {
            $searchValue = request()->input("search.value");
            $data = $data->where(function ($query) use ($searchValue){
                $query->whereRaw('kategori_iuran like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('bulan like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('tahun like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereRaw('nominal like ? ', ['%' . request()->input("search.value") . '%'])
                    ->orWhereHas('warga', function ($q) use ($searchValue) {
                        $q->where('nama_lengkap', 'like', '%' . $searchValue . '%');
                    });
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
            'warga_id' => 'required',
            'kategori' => 'required',
            'tanggal_iuran' => 'required',
            'nominal' => 'required',
        ]);
    }

    public function store(Request $request){

        $this->validation($request);
        $month = substr($request->tanggal_iuran, 5, 2);
        $year = substr($request->tanggal_iuran, 0, 4);
        $getBulan = $this->getBulan($month);
        

        $iuran = new TransaksiIuran();
        $iuran->warga_id = $request->warga_id;
        $iuran->kategori_iuran = $request->kategori;
        $iuran->tanggal_iuran = $request->tanggal_iuran;
        $iuran->bulan = $getBulan;
        $iuran->tahun = $year;
        $iuran->nominal = preg_replace('/[^0-9]/', '', $request->nominal);
        $iuran->save();

        return response()->json(['statusCode' => 200, 'message' => 'Berhasil menginput iuran warga']);
    }

    public function update(Request $request, $id){
        
        $this->validation($request);
        $month = substr($request->tanggal_iuran, 5, 2);
        $year = substr($request->tanggal_iuran, 0, 4);
        $getBulan = $this->getBulan($month);
        
        try {
            $iuran = TransaksiIuran::findOrFail($id);
            $iuran->warga_id = $request->warga_id;
            $iuran->kategori_iuran = $request->kategori;
            $iuran->tanggal_iuran = $request->tanggal_iuran;
            $iuran->bulan = $getBulan;
            $iuran->tahun = $year;
            $iuran->nominal = preg_replace('/[^0-9]/', '', $request->nominal);
            $iuran->update();
    
            return response()->json(['statusCode' => 200, 'message' => 'Berhasil menginput iuran warga']);
        } catch (\Throwable $th) {
            return response()->json(['statusCode' => 400, 'message' => 'Tidak berhasil di update'], 400);
        }
    }


    public function destroy($id){
        try {
            TransaksiIuran::destroy($id);
            return response()->json(['statusCode' => 200,'message' => 'Berhasil menghapus iuran warga']);
        } catch (\Throwable $th) {
            return response()->json(['statusCode' => 400, 'message' => 'Gagal menghapus transaksi'], 400);
        }
    }


    ####################################################################################################

    public function rekap(){

        return view('iuran.rekap', [
            'title' => 'Rekap Iuran',
            'menu' => 'iuran',
            'submenu' =>'rekap',
            'tahun' => $this->rangeTahun(),
        ]);
    }

    public function jsonRekap(){

        $columns = ['no_urut', 'warga', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        $orderBy = $columns[request()->input('order.0.column')];
        $direction = request()->input('order.0.dir');

        $tahun = request('tahun');

        $query = DB::table('wargas')
        // ->leftJoin('transaksi_iurans', 'wargas.id', '=', 'transaksi_iurans.warga_id')
        ->leftJoin('transaksi_iurans', function ($join) use ($tahun) {
            $join->on('wargas.id', '=', 'transaksi_iurans.warga_id')
                 ->where('transaksi_iurans.tahun', '=', $tahun); // Filter berdasarkan tahun
        })
        ->select(
            'wargas.id as no_urut',
            'wargas.nama_lengkap as warga',
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Januari" THEN transaksi_iurans.nominal ELSE 0 END) as Jan'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Februari" THEN transaksi_iurans.nominal ELSE 0 END) as Feb'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Maret" THEN transaksi_iurans.nominal ELSE 0 END) as Mar'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "April" THEN transaksi_iurans.nominal ELSE 0 END) as Apr'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Mei" THEN transaksi_iurans.nominal ELSE 0 END) as Mei'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Juni" THEN transaksi_iurans.nominal ELSE 0 END) as Jun'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Juli" THEN transaksi_iurans.nominal ELSE 0 END) as Jul'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Agustus" THEN transaksi_iurans.nominal ELSE 0 END) as Agt'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "September" THEN transaksi_iurans.nominal ELSE 0 END) as Sep'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Oktober" THEN transaksi_iurans.nominal ELSE 0 END) as Okt'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "November" THEN transaksi_iurans.nominal ELSE 0 END) as Nov'),
            DB::raw('SUM(CASE WHEN transaksi_iurans.bulan = "Desember" THEN transaksi_iurans.nominal ELSE 0 END) as Des')
        )
        ->where('tahun', request('tahun'))
        ->groupBy('wargas.id', 'wargas.nama_lengkap');
        

        // Filter untuk pencarian global
        if (request()->input('search.value')) {
            $search = request()->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('wargas.nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        // Hitung total records (untuk pagination DataTables)
        $recordsTotal = $query->get()->count();

        // Pagination
        $query->skip(request()->input('start'))->take(request()->input('length'));

        // Ordering
        $query->orderBy($orderBy, $direction);

        // Fetch data
        $data = $query->get();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data,
            'tahun' => request('tahun')
        ]);
    }   
}
