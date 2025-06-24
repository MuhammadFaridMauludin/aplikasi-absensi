<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        $karyawan = $query->paginate(10);

        $departement = DB::table('departement')->get();
        return view('karyawan.index', compact(
            'karyawan',
            'departement'
        ));
    }
    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jenis_kel = $request->jenis_kel;
        $jabatan = $request->jabatan;
        $kode_dep = $request->kode_dep;
        $no_hp = $request->no_hp;
        $password = Hash::make('1234');

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }
        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jenis_kel' => $jenis_kel,
                'jabatan' => $jabatan,
                'kode_dep' => $kode_dep,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $message = "Data dengan Nik " . $nik . " Sudah Ada";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan, ' . $message]);
        }
    }
    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departement = DB::table('departement')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departement', 'karyawan'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jenis_kel = $request->jenis_kel;
        $jabatan = $request->jabatan;
        $kode_dep = $request->kode_dep;
        $no_hp = $request->no_hp;
        $password = Hash::make('1234');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jenis_kel' => $jenis_kel,
                'jabatan' => $jabatan,
                'kode_dep' => $kode_dep,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "uploads/karyawan/";
                    $folderPathOld = "uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
            }
        } catch (\Exception $e) {
            // dd($e->message);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }
    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
