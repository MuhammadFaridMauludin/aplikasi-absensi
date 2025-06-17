<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dep = $request->nama_dep;
        $query = Departemen::query();
        $query->select('*');
        if (!empty($nama_dep)) {
            $query->where('nama_dep', 'like', '%' . $nama_dep . '%');
        }
        $departement = $query->get();
        // $departement = DB::table('departement')->orderBy('kode_dep')->get();
        return view('departement.index', compact('departement'));
    }
    public function store(Request $request)
    {
        $kode_dep = $request->kode_dep;
        $nama_dep = $request->nama_dep;
        $data = [
            'kode_dep' => $kode_dep,
            'nama_dep' => $nama_dep
        ];

        $simpan = DB::table('departement')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }
    public function edit(Request $request)
    {
        $kode_dep = $request->kode_dep;
        $departement = DB::table('departement')->where('kode_dep', $kode_dep)->first();
        return view('departement.edit', compact('departement'));
    }
    public function update($kode_dep, Request $request)
    {
        $nama_dep = $request->nama_dep;
        $data = [
            'nama_dep' => $nama_dep
        ];
        $update = DB::table('departement')->where('kode_dep', $kode_dep)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['Warning' => 'Data Gagal Di Update']);
        }
    }
    public function delete($kode_dep)
    {
        $hapus = DB::table('departement')->where('kode_dep', $kode_dep)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['Warning' => 'Data Gagal Di Hapus']);
        }
    }
}
