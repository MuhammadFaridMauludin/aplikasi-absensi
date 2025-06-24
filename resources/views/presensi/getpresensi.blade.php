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
        <button type="button" class="btn btn-sm btn-primary tampilkan-foto" 
                data-foto="{{ $foto_in }}" 
                data-nama="{{ $d->nama_lengkap }}" 
                data-type="masuk">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-photo"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
            Foto In
        </button>
    </td>
    <td>
        @if($vidio_in)
            <button type="button" class="btn btn-sm btn-success tampilkan-video" 
                    data-video="{{ $vidio_in }}" 
                    data-nama="{{ $d->nama_lengkap }}" 
                    data-type="masuk">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.117 7.625a1 1 0 0 0 -.564 .1l-4.553 2.275v4l4.553 2.275a1 1 0 0 0 1.447 -.892v-6.766a1 1 0 0 0 -.883 -.992z" /><path d="M5 5c-1.645 0 -3 1.355 -3 3v8c0 1.645 1.355 3 3 3h8c1.645 0 3 -1.355 3 -3v-8c0 -1.645 -1.355 -3 -3 -3z" /></svg>
                Video In
            </button>
        @else
            <span class="text-muted">No video</span>
        @endif
    </td>
    <td>{!! $d->jam_out !== null ? $d->jam_out : '<span class="badge bg-danger text-white">Belum absen</span>'!!}</td>
    <td>
        @if ($d->jam_out !== null)
            <button type="button" class="btn btn-sm btn-primary tampilkan-foto" 
                    data-foto="{{ $foto_out }}" 
                    data-nama="{{ $d->nama_lengkap }}" 
                    data-type="keluar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-photo"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
                Foto Out
            </button>
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
        @if($d->jam_out !== null && $vidio_out)
            <button type="button" class="btn btn-sm btn-success tampilkan-video" 
                    data-video="{{ $vidio_out }}" 
                    data-nama="{{ $d->nama_lengkap }}" 
                    data-type="keluar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.117 7.625a1 1 0 0 0 -.564 .1l-4.553 2.275v4l4.553 2.275a1 1 0 0 0 1.447 -.892v-6.766a1 1 0 0 0 -.883 -.992z" /><path d="M5 5c-1.645 0 -3 1.355 -3 3v8c0 1.645 1.355 3 3 3h8c1.645 0 3 -1.355 3 -3v-8c0 -1.645 -1.355 -3 -3 -3z" /></svg>
                Video Out
            </button>
        @else
            <span class="text-muted">No video</span>
        @endif
    </td>
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
         <button type="button" class="btn btn-sm btn-primary tampilkanpeta" id="{{ $d->id }}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" /></svg>
                Lokasi
            </button>
@endforeach

<!-- Script untuk event handlers (letakkan di main view) -->
<script>
    $(function(){
        // Event handler untuk tampilkan peta (existing) - menggunakan event delegation
        $(document).on('click', '.tampilkanpeta', function(e){
            e.preventDefault();
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
        });

        // Event handler untuk tampilkan foto - menggunakan event delegation
        $(document).on('click', '.tampilkan-foto', function(e){
            e.preventDefault();
            var foto_url = $(this).data('foto');
            var nama = $(this).data('nama');
            var type = $(this).data('type');
            
            $("#modal-foto-title").text('Foto ' + (type === 'masuk' ? 'Masuk' : 'Keluar') + ' - ' + nama);
            $("#modal-foto-img").attr('src', foto_url);
            $("#modal-foto-download").attr('href', foto_url);
            $("#modal-foto").modal('show');
        });

        // Event handler untuk tampilkan video - menggunakan event delegation
        $(document).on('click', '.tampilkan-video', function(e){
            e.preventDefault();
            var video_url = $(this).data('video');
            var nama = $(this).data('nama');
            var type = $(this).data('type');
            
            $("#modal-video-title").text('Video ' + (type === 'masuk' ? 'Masuk' : 'Keluar') + ' - ' + nama);
            $("#modal-video-source").attr('src', video_url);
            $("#modal-video-download").attr('href', video_url);
            
            // Reload video element to apply new source
            var video = document.getElementById('modal-video-player');
            if(video) {
                video.load();
            }
            
            $("#modal-video").modal('show');
        });

        // Pause video when modal is closed
        $('#modal-video').on('hidden.bs.modal', function () {
            var video = document.getElementById('modal-video-player');
            if(video) {
                video.pause();
                video.currentTime = 0;
            }
        });
    });
</script>