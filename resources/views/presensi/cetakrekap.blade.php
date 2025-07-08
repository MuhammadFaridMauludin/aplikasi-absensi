<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rekap Presensi Karyawan</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <style>
  @page { 
    size: A4 landscape;
    margin: 5mm;
  }

  body {
    font-family: 'Arial', sans-serif;
    font-size: 7px;
    line-height: 1.1;
    color: #333;
  }

  /* Header Styles */
  .header-section {
    border-bottom: 2px solid #2c5aa0;
    padding-bottom: 5px;
    margin-bottom: 10px;
  }

  .header-table {
    width: 100%;
    vertical-align: top;
  }

  .logo-cell {
    width: 60px;
    text-align: center;
    vertical-align: middle;
  }

  .logo-cell img {
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  .company-info {
    vertical-align: middle;
    padding-left: 15px;
  }

  .company-name {
    font-family: 'Times New Roman', Times, serif;
    font-size: 12px;
    font-weight: bold;
    color: #2c5aa0;
    margin-bottom: 2px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .report-title {
    font-size: 10px;
    font-weight: bold;
    color: #333;
    margin-bottom: 1px;
  }

  .company-address {
    font-style: italic;
    color: #666;
    font-size: 7px;
    margin-top: 2px;
  }

  /* Main Table Styles */
  .tabelpresensi {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
    font-size: 6px;
  }

  .tabelpresensi th {
    background: #2c5aa0;
    color: white;
    font-weight: bold;
    text-align: center;
    padding: 3px 1px;
    border: 1px solid #1e3d72;
    font-size: 5px;
    text-transform: uppercase;
    letter-spacing: 0.2px;
    vertical-align: middle;
  }

  .tabelpresensi th.header-main {
    font-size: 6px;
    padding: 4px 2px;
    writing-mode: horizontal-tb;
  }

  .tabelpresensi th.date-header {
    writing-mode: vertical-rl;
    text-orientation: mixed;
    min-width: 12px;
    max-width: 12px;
    font-size: 5px;
    padding: 2px 1px;
  }

  .tabelpresensi td {
    border: 1px solid #ccc;
    padding: 1px;
    text-align: center;
    vertical-align: middle;
    background-color: #fff;
    font-size: 5px;
    line-height: 1;
  }

  .tabelpresensi tr:nth-child(even) td {
    background-color: #f8f9fa;
  }

  .tabelpresensi tr:hover td {
    background-color: #e3f2fd;
  }

  /* Employee Info Columns */
  .employee-nik {
    min-width: 50px;
    max-width: 50px;
    font-weight: bold;
    background-color: #f5f5f5 !important;
    text-align: left;
    padding-left: 2px;
    font-size: 5px;
  }

  .employee-name {
    min-width: 80px;
    max-width: 80px;
    font-weight: bold;
    background-color: #f5f5f5 !important;
    text-align: left;
    padding-left: 2px;
    font-size: 5px;
  }

  /* Date Cells */
  .date-cell {
    min-width: 12px;
    max-width: 12px;
    padding: 1px;
    font-size: 4px;
    line-height: 1;
  }

  .date-cell .time-in {
    color: #333;
    font-weight: bold;
    margin-bottom: 1px;
  }

  .date-cell .time-out {
    color: #666;
  }

  .date-cell .time-late {
    color: #dc3545 !important;
    font-weight: bold;
  }

  .date-cell .time-early {
    color: #ffc107 !important;
  }

  .date-cell .time-normal {
    color: #28a745 !important;
  }

  /* Summary Columns */
  .summary-cell {
    min-width: 20px;
    font-weight: bold;
    font-size: 6px;
    background-color: #e8f4f8 !important;
  }

  .summary-hadir {
    color: #28a745;
  }

  .summary-terlambat {
    color: #dc3545;
  }

  /* Weekend Styling */
  .weekend-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
  }

  .weekend-cell {
    background-color: #ffe6e6 !important;
  }

  /* Legend */
  .legend-section {
    margin: 8px 0;
    padding: 5px;
    background-color: #f8f9fa;
    border-radius: 3px;
    border-left: 2px solid #2c5aa0;
  }

  .legend-title {
    font-weight: bold;
    color: #2c5aa0;
    margin-bottom: 3px;
    font-size: 7px;
  }

  .legend-items {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 6px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 3px;
  }

  .legend-color {
    width: 8px;
    height: 8px;
    border-radius: 1px;
    border: 1px solid #ddd;
  }

  /* Signature Section */
  .signature-section {
    margin-top: 15px;
    page-break-inside: avoid;
  }

  .signature-table {
    width: 100%;
  }

  .signature-date {
    text-align: right;
    padding-bottom: 8px;
    font-weight: bold;
    color: #555;
    font-size: 7px;
  }

  .signature-cell {
    text-align: center;
    vertical-align: bottom;
    height: 50px;
    width: 120px;
    border-top: 1px solid #ddd;
    padding-top: 5px;
  }

  .signature-name {
    font-weight: bold;
    text-decoration: underline;
    margin-bottom: 2px;
    font-size: 7px;
  }

  .signature-position {
    font-style: italic;
    color: #666;
    font-size: 6px;
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

    .weekend-header {
      background: #dc3545 !important;
    }
  }

  /* Responsive adjustments */
  .compact-mode {
    font-size: 6px;
  }

  .compact-mode .date-cell {
    padding: 1px;
  }

  .compact-mode .tabelpresensi th {
    padding: 4px 2px;
    font-size: 6px;
  }
  </style>
</head>

<body class="A4 landscape">
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
            <img src="{{ asset('assets/img/logoevergreen1.png') }}" width="50" height="50" alt="Logo Perusahaan">
          </td>
          <td class="company-info">
            <div class="company-name">PT. Indonesia Evergreen Agriculture Lampung</div>
            <div class="report-title">Rekap Presensi Karyawan</div>
            <div class="report-title">Periode {{ strtoupper($nama_bulan[$bulan]) }} {{ $tahun }}</div>
            <div class="company-address">Jl. Soekarno Harta KM.33 Desa Bandar Dalam, Lampung Selatan</div>
          </td>
        </tr>
      </table>
    </div>

    <!-- Legend Section -->
    <div class="legend-section">
      <div class="legend-title">Keterangan:</div>
      <div class="legend-items">
        <div class="legend-item">
          <div class="legend-color" style="background-color: #28a745;"></div>
          <span>Tepat Waktu</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background-color: #dc3545;"></div>
          <span>Terlambat (> 07:00)</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background-color: #ffc107;"></div>
          <span>Pulang Cepat (< 16:00)</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background-color: #ffe6e6;"></div>
          <span>Weekend (Sabtu)</span>
        </div>
        <div class="legend-item">
          <span><strong>TH:</strong> Total Hadir</span>
        </div>
        <div class="legend-item">
          <span><strong>TT:</strong> Total Terlambat</span>
        </div>
      </div>
    </div>

    <!-- Main Attendance Table -->
    <table class="tabelpresensi">
      <thead>
        <tr>
          <th rowspan="2" class="header-main">NIK</th>
          <th rowspan="2" class="header-main">Nama Karyawan</th>
          <th colspan="{{ count($validDays) }}" class="header-main">Tanggal</th>
          <th rowspan="2" class="header-main">TH</th>
          <th rowspan="2" class="header-main">TT</th>
        </tr>
        <tr>
          @foreach($validDays as $day)
            <?php
            // Determine if weekend (Saturday only, since Sunday is excluded)
            $date = date('w', mktime(0, 0, 0, $bulan, $day, $tahun));
            $isWeekend = ($date == 6); // Only Saturday
            $weekendClass = $isWeekend ? 'weekend-header' : '';
            ?>
            <th class="date-header {{ $weekendClass }}">{{ $day }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($rekap as $d)
        <tr>
          <td class="employee-nik">{{ $d->nik }}</td>
          <td class="employee-name">{{ $d->nama_lengkap }}</td>
          <?php
          $totalhadir = 0;
          $totalterlambat = 0;
          ?>
          @foreach($validDays as $day)
            <?php
            $tgl = "tgl_" . $day;
            
            // Determine if weekend (Saturday only)
            $date = date('w', mktime(0, 0, 0, $bulan, $day, $tahun));
            $isWeekend = ($date == 6);
            $weekendClass = $isWeekend ? 'weekend-cell' : '';
            
            if (empty($d->$tgl)) {
                $hadir = ['',''];
                $totalhadir += 0;
            } else {
                $hadir = explode("-",$d->$tgl);
                $totalhadir += 1;
                if ($hadir[0] > "07:00:00") {
                    $totalterlambat += 1;
                }
            }

            // Determine CSS classes for time styling
            $timeInClass = '';
            $timeOutClass = '';
            
            if (!empty($hadir[0])) {
                $timeInClass = $hadir[0] > "07:00:00" ? 'time-late' : 'time-normal';
            }
            
            if (!empty($hadir[1])) {
                $timeOutClass = $hadir[1] < "16:00:00" ? 'time-early' : 'time-normal';
            }
            ?>
            <td class="date-cell {{ $weekendClass }}">
                @if (!empty($hadir[0]))
                    <div class="time-in {{ $timeInClass }}">
                        {{ substr($hadir[0], 0, 5) }}
                    </div>
                @endif
                @if (!empty($hadir[1]))
                    <div class="time-out {{ $timeOutClass }}">
                        {{ substr($hadir[1], 0, 5) }}
                    </div>
                @endif
            </td>
          @endforeach
          <td class="summary-cell summary-hadir">{{ $totalhadir }}</td>
          <td class="summary-cell summary-terlambat">{{ $totalterlambat }}</td>
        </tr>  
        @endforeach
      </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
      <table class="signature-table">
        <tr>
          <td class="signature-date" colspan="3">Lampung Selatan, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
          <td style="width: 50%"></td>
          <td class="signature-cell">
            <div class="signature-name">( Hadi Santoso )</div>
            <div class="signature-position">Human Resource Development</div>
          </td>
          <td class="signature-cell">
            <div class="signature-name">( Bambang Siswanto )</div>
            <div class="signature-position">Departemen Manager</div>
          </td>
        </tr>
      </table>
    </div>

  </section>

</body>
</html>