<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dep');
        $query->join('departement', 'karyawan.kode_dep', '=', 'departement.kode_dep');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        if (!empty($request->kode_dep)) {
            $query->where('karyawan.kode_dep', $request->kode_dep);
        }
        $karyawan = $query->paginate(2);

        $departement = DB::table('departement')->get();
        return view('karyawan.index', compact(
            'karyawan',
            'departement'
        ));
    }
}
