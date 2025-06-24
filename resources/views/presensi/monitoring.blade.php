@extends('layouts.admin.tabler')
@section('content')

    <div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Monitoring Absensi</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row">
                    <div class="col-12">
                       <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                     <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 2a1 1 0 0 1 .993 .883l.007 .117v1h1a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h1v-1a1 1 0 0 1 1.993 -.117l.007 .117v1h6v-1a1 1 0 0 1 1 -1m3 7h-14v9.625c0 .705 .386 1.286 .883 1.366l.117 .009h12c.513 0 .936 -.53 .993 -1.215l.007 -.16z" /><path d="M8 14h2v2h-2z" /></svg>
                                </span>
                                <input type="text" id="tanggal" value="{{ date("Y-m-d")}}" name="tanggal" value="" class="form-control" placeholder="Tanggal Presensi" autocomplete="off">                               
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-stripped table-hover">
                                            <thead>
                                                <tr>
                                                 <th>No</th>
                                                 <th>Nik</th>
                                                 <th>Nama Karyawan</th>
                                                 <th>Departement</th>
                                                 <th>Jam Masuk </th>
                                                 <th>Foto In</th>
                                                 <th>Video In</th>
                                                 <th>Jam Pulang</th>
                                                 <th>Foto Out</th>
                                                 <th>Video Out</th>
                                                 <th>Keterangan</th>
                                                 <th>Lokasi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadpresensi">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal untuk menampilkan lokasi -->
        <div class="modal modal-blur fade" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lokasi Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="loadmap">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menampilkan foto -->
        <div class="modal modal-blur fade" id="modal-foto" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-foto-title">Foto Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modal-foto-img" src="" alt="Foto Absensi" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menampilkan video -->
        <div class="modal modal-blur fade" id="modal-video" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-video-title">Video Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <video id="modal-video-player" controls style="width: 100%; max-height: 300px;">
                            <source id="modal-video-source" src="" type="video/webm">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        
                    </div>
                </div>
            </div>
        </div>

@endsection
@push('myscript')
    <script>
         $(function(){
             $("#tanggal").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });

            function loadpresensi(){
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url:'/getpresensi',
                    data:{
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache:false,
                    success:function(respond){
                        $("#loadpresensi").html(respond);
                    }
                });
            }
            
            $('#tanggal').change(function(e){
                loadpresensi();
            });
            
            loadpresensi();

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
@endpush