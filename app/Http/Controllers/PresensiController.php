<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Node\HashNode;

class PresensiController extends Controller
{
    public function create()
    {
        $harini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $harini)->where('nik', $nik)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $video = $request->video;

        $folderPath = "uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . '-' . $ket;

        // Simpan foto
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        // Simpan video
        if ($video) {
            $video_parts = explode(";base64,", $video);
            $video_base64 = base64_decode($video_parts[1]);
            $videoName = $formatName . ".webm";
            $videoFile = $folderPath . $videoName;
            Storage::put($videoFile, $video_base64);
        }

        // Simpan ke database
        $data = [
            'nik' => $nik,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'vidio_in' => $videoName ?? null,
            'lokasi_in' => $lokasi
        ];
        //validari radius
        if ($radius > $lok_kantor->radius) {
            echo "erorr|Maaf Anda Berada Diluar Radius Kantor, jarak anda " . $radius . " Meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'vidio_out' => $videoName ?? null,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    echo "success|Absen Pulang Berhasil, hati hati di jalan |out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "erorr|Absensi Gagal, Hubungi Tim IT|out";
                }
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'vidio_in' => $videoName ?? null,
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Absen Masuk Berhasil, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "erorr|Absensi Gagal, Hubungi Tim IT|out";
                }
            }
        }
    }
    //untuk menghitung jarak 
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }
    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

        $data = [];

        // Update nama lengkap jika ada input
        if ($request->filled('nama_lengkap')) {
            $data['nama_lengkap'] = $request->nama_lengkap;
        }

        // Update no_hp jika ada input
        if ($request->filled('no_hp')) {
            $data['no_hp'] = $request->no_hp;
        }

        // Update password hanya jika user isi password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update foto hanya jika ada upload file baru
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $maxSize = 2 * 1024 * 1024; // 2MB dalam byte

            if ($file->getSize() > $maxSize) {
                // Ukuran file terlalu besar, kembalikan dengan error
                return Redirect::back()->with(['error' => 'Ukuran gambar terlalu besar. Maksimal 2MB']);
            }

            $foto = $nik . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $foto;
        } else {
            // Jika tidak upload foto baru, biarkan tetap seperti semula
            $data['foto'] = $karyawan->foto;
        }

        // Update ke DB jika ada data yang berubah
        if (!empty($data)) {
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);

            if ($update) {
                // Jika upload foto, simpan filenya
                if ($request->hasFile('foto')) {
                    $folderPath = "uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $data['foto']);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
            } else {
                return Redirect::back()->with(['error' => 'Data Gagal Diupdate']);
            }
        } else {
            // Tidak ada data yang diupdate
            return Redirect::back()->with(['info' => 'Tidak ada perubahan data']);
        }
    }

    public function history()
    {
        $nama_bulan = ["", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "december"];
        return view('presensi.history', compact('nama_bulan'));
    }
    public function gethistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistory', compact('history'));
    }
    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }
    public function pengajuanizin()
    {
        return view('presensi.pengajuanizin');
    }
    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $simpan = DB::table('pengajuan_izin')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'data berhasil disimpan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'data Gagal disimpan']);
        }
    }
    public function monitoring()
    {
        return view('presensi.monitoring');
    }
    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'nama_dep')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('departement', 'karyawan.kode_dep', '=', 'departement.kode_dep')
            ->where('tgl_presensi', $tanggal)
            ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }
    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->first();
        return view('presensi.showmap', compact('presensi'));
    }
    public function laporan()
    {
        $nama_bulan = ["", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "december"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('nama_bulan', 'karyawan'));
    }
    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nama_bulan = ["", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "december"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
            ->join('departement', 'karyawan.kode_dep', '=', 'departement.kode_dep')
            ->first();

        $presensi = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('Month(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('Year(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel 
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Presensi Karyawan $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'nama_bulan', 'karyawan', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'nama_bulan', 'karyawan', 'presensi'));
    }
    public function rekap()
    {
        $nama_bulan = ["", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "december"];
        return view('presensi.rekap', compact('nama_bulan'));
    }
    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nama_bulan = ["", "januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "december"];
        $rekap = DB::table('presensi')
            ->selectRaw('presensi.nik,nama_lengkap,
                MAX(IF(DAY(tgl_presensi) = 1,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_1,
                MAX(IF(DAY(tgl_presensi) = 2,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_2,
                MAX(IF(DAY(tgl_presensi) = 3,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_3,
                MAX(IF(DAY(tgl_presensi) = 4,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_4,
                MAX(IF(DAY(tgl_presensi) = 5,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_5,
                MAX(IF(DAY(tgl_presensi) = 6,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_6,
                MAX(IF(DAY(tgl_presensi) = 7,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_7,
                MAX(IF(DAY(tgl_presensi) = 8,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_8,
                MAX(IF(DAY(tgl_presensi) = 9,  CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_9,
                MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_10,
                MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_11,
                MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_12,
                MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_13,
                MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_14,
                MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_15,
                MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_16,
                MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_17,
                MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_18,
                MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_19,
                MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_20,
                MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_21,
                MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_22,
                MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_23,
                MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_24,
                MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_25,
                MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_26,
                MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_27,
                MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_28,
                MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_29,
                MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_30,
                MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_31')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nik,nama_lengkap')
            ->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel 
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Rekap Presensi Karyawan $time.xls");
        }
        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap', 'nama_bulan'));
    }
    public function izinsakit(Request $request)
    {

        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }

        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved != "") {
            $query->where('status_approved', $request->status_approved);
        }

        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->paginate(2);
        $izinsakit->append($request->all());
        return view('presensi.izinsakit', compact('izinsakit'));
    }
    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('pengajuan_izin')
            ->where('id', $id_izinsakit_form)
            ->update(['status_approved' => $status_approved]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal DI Update']);
        }
    }
    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update(['status_approved' => 0]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal DI Update']);
        }
    }
    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
