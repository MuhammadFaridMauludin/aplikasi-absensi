@foreach ($presensi as $d)
@php
    $foto_in = Storage::url('uploads/absensi/'.$d->foto_in);
    $foto_out = Storage::url('uploads/absensi/'.$d->foto_out);
    
    // Check if video properties exist before using them
    $vidio_in = isset($d->vidio_in) && $d->vidio_in ? Storage::url('uploads/absensi/'.$d->vidio_in) : null;
    $vidio_out = isset($d->vidio_out) && $d->vidio_out ? Storage::url('uploads/absensi/'.$d->vidio_out) : null;
@endphp

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $d->nik }}</td>
    <td>{{ $d->nama_lengkap}}</td>
    <td>{{ $d->nama_dep}}</td>
    <td>{{ $d->jam_in}}</td>
    <td>
        <a href="{{ url($foto_in) }}" target="_blank">
            <img src="{{ url($foto_in) }}" alt="foto masuk" width="60">
        </a>
    </td>
    <td>
        @if($vidio_in)
            <video width="200" controls>
                <source src="{{ $vidio_in }}" type="video/webm">
                Your browser does not support the video tag.
            </video>
        @else
            <span class="text-muted">No video</span>
        @endif
    </td>
    <td>{!! $d->jam_out !== null ? $d->jam_out : '<span class="badge bg-danger text-white">Belum absen</span>'!!}</td>
    <td>
    @if ($d->jam_out !== null)
        <a href="{{ url($foto_out) }}" target="_blank">
            <img src="{{ url($foto_out) }}" alt="foto keluar" width="60">
        </a>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-empty">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" />
            <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
        </svg>
    @endif
</td>

    <td>
        @if($vidio_in)
            <video width="150" controls>
                <source src="{{ $vidio_in }}" type="video/webm">
                Your browser does not support the video tag.
            </video>
        @else
            <span class="text-muted">No video</span>
        @endif
    </td>
    <td>
        @if ($d->jam_in >='07.00')
        <span class="badge bg-danger text-white">Terlambat</span>
        @else
        <span class="badge bg-success text-white">Tepat waktu</span>
        @endif
    </td>
</tr>
@endforeach