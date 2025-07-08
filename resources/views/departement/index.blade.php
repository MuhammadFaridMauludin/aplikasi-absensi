@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Data Departemen</h2>
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
                                    @if (Session::get('success'))
                                    <div class="alert alert-success">
                                            {{Session::get('success')}}
                                  </div>
                                    @endif

                                     @if (Session::get('warning'))
                                    <div class="alert alert-warning">
                                    {{Session::get('warning')}}
                                       
                                  </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahDepartement">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z" /></svg>
                                        Tambah data</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-10">
                                     <form action="/departement" method="GET">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <input type="text" name="nama_dep" id="nama_dep" class="form-control" placeholder="Departement" value="{{ Request('nama_dep')}}">
                                        </div>
                                    </div>
                                   
                                    <div class="col-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                            Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Departement</th>
                                <th>Nama Departement</th>
                                <th>action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($departement as $d)
                               <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->kode_dep }}</td>
                                <td>{{ $d->nama_dep }}</td>
                                <td>
                                    <div class="btn-group">
                                            <a href="#" class="edit btn btn-info btn-sm" kode_dep="{{ $d->kode_dep }}">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            </a>
                                        <form action="/departement/{{ $d->kode_dep }}/delete" method="POST" style="margin-left: 5px">
                                            @csrf 
                                            
                                            <a class="delete-confirm btn btn-danger btn-sm">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                            </a>
                                        </form>
                                        </div>
                                       </td>
                            </tr>

                           @endforeach
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
    <div class="modal modal-blur fade" id="modal-inputdepartement" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <h5 class="modal-title">Tambah data departement</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="/departement/store" method="POST" id="frmDepartement">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-braille"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 5a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M7 5a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M7 19a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M16 12h.01" /><path d="M8 12h.01" /><path d="M16 19h.01" /></svg>
                                </span>
                                <input type="text" id="kode_dep" value="" class="form-control" name="kode_dep" placeholder="Kode Departement">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" id="nama_dep" value="" class="form-control" name="nama_dep" placeholder="Nama departement">
                    </div>
                </div>
            </div>
           
           <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary w-100"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                        Simpan Data</button>
                </div>
            </div>
           </div>
          </form>
        </div>
        </div>
      </div>
    </div>
    {{-- modal edit --}}
       <div class="modal modal-blur fade" id="modal-editdepartement" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <h5 class="modal-title">Edit Data Departement</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadeditform">
          
        </div>
        </div>
      </div>
    </div>
    
@endsection

@push('myscript')

    <script>
$(function(){
    $("#btnTambahDepartement").click(function(){
        $("#modal-inputdepartement").modal('show');
    });
    $(".edit").click(function(){
        var kode_dep = $(this).attr('kode_dep');
        $.ajax({
            type:'POST',
            url:'/departement/edit',
            cache: false,
            data:{
                _token:"{{ csrf_token(); }}",
                kode_dep: kode_dep
            },
            success:function(respond){
                $("#loadeditform").html(respond);
            }
        })
        $("#modal-editdepartement").modal('show');
    });
    $(".delete-confirm").click(function(e){
        var form = $(this).closest('form');
        e.preventDefault();
        Swal.fire({
        title: "apa anda yakin untuk menghapus data tersebut ?",
        text: "data akan dihapus permanen!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Iya, Hapus Sekarang",
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            form.submit();
            Swal.fire("Deleted", "Data Berhasil Dihapus", "success");
        }
    });
    });
    $("#frmKaryawan").submit(function() {
        var nik = $("#nik").val();
        var nama_lengkap = $("#nama_lengkap").val();
        var jenis_kel = $("#jenis_kel").val();
        var jabatan = $("#jabatan").val();
        var kode_dep = $("#frmKaryawan").find("#kode_dep").val();
        var no_hp = $("#no_hp").val();
        if(nik == ""){
            //  alert('Nik harus diisi');
            Swal.fire({
            title: 'Oops!',
            text: 'Nik Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nik").focus();
            })
            return false;
        }else if(nama_lengkap == "") {
            Swal.fire({
            title: 'Oops!',
            text: 'Nama Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_lengkap").focus();
            })
        }else if(jenis_kel == "") {
            Swal.fire({
            title: 'Oops!',
            text: 'Jenis Kelamin Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jenis_kel").focus();
            })
        }else if(jabatan == "") {
            Swal.fire({
            title: 'Oops!',
            text: 'Jabatan Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jabatan").focus();
            })
        }else if(kode_dep == "") {
            Swal.fire({
            title: 'Oops!',
            text: 'Departemen Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_dep").focus();
            })
        }else if(no_hp == "") {
            Swal.fire({
            title: 'Oops!',
            text: 'Nomer Hp Harus Diisi',
            icon: 'error',
            confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_hp").focus();
            })
        }
    });
});
    </script>
@endpush