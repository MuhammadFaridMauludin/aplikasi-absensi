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

    {{-- <td>
        @if($vidio_in)
            <video width="150" controls>
                <source src="{{ $vidio_in }}" type="video/webm">
                Your browser does not support the video tag.
            </video>
        @else
            <span class="text-muted">No video</span>
        @endif
    </td> --}}
    <td>
        @if ($d->jam_in >='07.00')
        @php
            $jamterlambat = selisih('07:00:00',$d->jam_in);
        @endphp
        <span class="badge bg-danger text-white">Terlambat {{ $jamterlambat }}</span>
        @else
        <span class="badge bg-success text-white">Tepat waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $d->id }}">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" /></svg>
        </a>
    </td>
</tr>
<script>
    $(function(){
        $(".tampilkanpeta").click(function(e){
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data : {
                    _token: "{{ csrf_token() }}",
                    id:id
                },
                cache:false,
                success:function(respond){
                    $("#loadmap").html(respond);
                }
            })
            $("#modal-tampilkanpeta").modal('show');
        })
    })
</script>
@endforeach