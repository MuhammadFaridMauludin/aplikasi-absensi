<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi Karyawan</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <style>
  @page { 
    size: A4;
    margin: 15mm;
  }

  body {
    font-family: 'Arial', sans-serif;
    font-size: 11px;
    line-height: 1.4;
    color: #333;
  }

  /* Header Styles */
  .header-section {
    border-bottom: 3px solid #2c5aa0;
    padding-bottom: 15px;
    margin-bottom: 25px;
  }

  .header-table {
    width: 100%;
    vertical-align: top;
  }

  .logo-cell {
    width: 80px;
    text-align: center;
    vertical-align: middle;
  }

  .company-info {
    vertical-align: middle;
    padding-left: 20px;
  }

  .company-name {
    font-family: 'Times New Roman', Times, serif;
    font-size: 18px;
    font-weight: bold;
    color: #2c5aa0;
    margin-bottom: 5px;
    text-transform: uppercase;
  }

  .report-title {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin-bottom: 3px;
  }

  .company-address {
    font-style: italic;
    color: #666;
    font-size: 10px;
    margin-top: 5px;
  }

  /* Employee Data Section */
  .employee-section {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
  }

  .employee-section h3 {
    margin: 0 0 15px 0;
    color: #2c5aa0;
    font-size: 14px;
    border-bottom: 2px solid #2c5aa0;
    padding-bottom: 5px;
  }

  .employee-table {
    width: 100%;
  }

  .employee-photo {
    width: 100px;
    text-align: center;
    vertical-align: top;
    padding-right: 20px;
  }

  .employee-photo img {
    width: 90px;
    height: 120px;
    border: 2px solid #ddd;
    border-radius: 8px;
    object-fit: cover;
  }

  .employee-data {
    vertical-align: top;
  }

  .employee-data table {
    width: 100%;
  }

  .employee-data td {
    padding: 8px 0;
    vertical-align: top;
  }

  .employee-data .label {
    font-weight: bold;
    width: 140px;
    color: #555;
  }

  .employee-data .separator {
    width: 15px;
    text-align: center;
    color: #777;
  }

  .employee-data .value {
    color: #333;
  }

  /* Attendance Table */
  .attendance-section h3 {
    margin: 0 0 15px 0;
    color: #2c5aa0;
    font-size: 14px;
    border-bottom: 2px solid #2c5aa0;
    padding-bottom: 5px;
  }

  .tabelpresensi {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
  }

  .tabelpresensi th {
    background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
    color: white;
    font-weight: bold;
    text-align: center;
    padding: 12px 8px;
    border: none;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .tabelpresensi td {
    border: 1px solid #dee2e6;
    padding: 10px 8px;
    text-align: center;
    vertical-align: middle;
    background-color: #fff;
  }

  .tabelpresensi tr:nth-child(even) td {
    background-color: #f8f9fa;
  }

  .tabelpresensi tr:hover td {
    background-color: #e3f2fd;
  }

  .foto {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #ddd;
  }

  /* Status Styling */
  .status-ontime {
    color: #28a745;
    font-weight: bold;
  }

  .status-late {
    color: #dc3545;
    font-weight: bold;
  }

  .status-not-out {
    color: #ffc107;
    font-weight: bold;
  }

  /* Signature Section */
  .signature-section {
    margin-top: 40px;
    page-break-inside: avoid;
  }

  .signature-table {
    width: 100%;
  }

  .signature-date {
    text-align: right;
    padding-bottom: 20px;
    font-weight: bold;
    color: #555;
  }

  .signature-cell {
    text-align: center;
    vertical-align: bottom;
    height: 100px;
    width: 200px;
    border-top: 1px solid #ddd;
    padding-top: 15px;
  }

  .signature-name {
    font-weight: bold;
    text-decoration: underline;
    margin-bottom: 5px;
  }

  .signature-position {
    font-style: italic;
    color: #666;
    font-size: 10px;
  }

  /* Print Optimization */
  @media print {
    .sheet {
      margin: 0;
      box-shadow: none;
    }
    
    body {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .tabelpresensi th {
      background: #2c5aa0 !important;
      color: white !important;
    }
  }

  .no-break {
    page-break-inside: avoid;
  }
  </style>
</head>

<body class="A4">
@php
     function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }    
@endphp

  <section class="sheet padding-10mm">
    
    <!-- Header Section -->
    <div class="header-section">
      <table class="header-table">
        <tr>
          <td class="logo-cell">
            <img src="{{ asset('assets/img/logoevergreen1.png') }}" width="70" height="70" alt="">
          </td>
          <td class="company-info">
            <div class="company-name">PT. Indonesia Evergreen Agriculture Lampung</div>
            <div class="report-title">Laporan Presensi Karyawan</div>
            <div class="report-title">Periode {{ strtoupper($nama_bulan[$bulan]) }} {{ $tahun }}</div>
            <div class="company-address">Jl. Soekarno Harta KM.33 Desa Bandar Dalam, Lampung Selatan</div>
          </td>
        </tr>
      </table>
    </div>

    <!-- Employee Information Section -->
    <div class="employee-section no-break">
      <h3>Data Karyawan</h3>
      <table class="employee-table">
        <tr>
          <td class="employee-photo">
            @php
                $path = Storage::url('uploads/karyawan/' .$karyawan->foto);
            @endphp
            <img src="{{ url($path) }}" alt="Foto Karyawan" width="90" height="120">
          </td>
          <td class="employee-data">
            <table>
              <tr>
                <td class="label">Nama Lengkap</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->nama_lengkap }}</td>
              </tr>
              <tr>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->nik }}</td>
              </tr>
              <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->jabatan }}</td>
              </tr>
              <tr>
                <td class="label">Departemen</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->nama_dep }}</td>
              </tr>
              <tr>
                <td class="label">No. Handphone</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->no_hp }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>

    <!-- Attendance Table Section -->
    <div class="attendance-section">
      <h3>Rincian Presensi</h3>
      <table class="tabelpresensi">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Keterangan</th>
            <th>Total Jam</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($presensi as $d)
          @php
              $jamterlambat = selisih('07:00:00',$d->jam_in);
          @endphp
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
              <td>{{ $d->jam_in }}</td>
              <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen'}}</td>
              <td>
                  @if ($d->jam_in > '07:00')
                      <span class="status-late">Terlambat {{ $jamterlambat }}</span>
                  @else
                      <span class="status-ontime">Tepat Waktu</span>
                  @endif
              </td>
              <td>
                  @if ($d->jam_out != null)
                  @php
                      $jmljamkerja = selisih($d->jam_in,$d->jam_out);
                  @endphp
                  {{ $jmljamkerja }}
                  @else
                  <span class="status-not-out">0</span>
                  @endif
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
      <table class="signature-table">
        <tr>
          <td class="signature-date" colspan="3">Lampung Selatan, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
          <td style="width: 50%"></td>
          <td class="signature-cell">
            <div class="signature-name">( Suprat )</div>
            <div class="signature-position">Human Resource Development</div>
          </td>
          <td class="signature-cell">
            <div class="signature-name">( Suprat )</div>
            <div class="signature-position">Human Resource Development</div>
          </td>
        </tr>
      </table>
    </div>

  </section>

</body>
</html>