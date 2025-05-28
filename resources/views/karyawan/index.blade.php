@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Data karyawan</h2>
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
                                    <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z" /></svg>
                                        Tambah data</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                     <form action="/karyawan" method="GET">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="nama_karyawan" name="nama_karyawan" class="form-control" placeholder="Nama Karyawan" value="{{ Request('nama_karyawan')}}">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <select name="kode_dep" id="kode_dep" class="form-select">
                                                <option value="">Departement</option>
                                                @foreach ($departement as $d)
                                                    <option {{ Request('kode_dep')==$d->kode_dep ? 'selected' : ''}} value="{{ $d->kode_dep }}">{{ $d->nama_dep}}</option>
                                                @endforeach
                                            </select>
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
                                <th>Nik</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Kode departemen</th>
                                <th>No Hp</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $d)
                            @php
                                $path = Storage::url('/uploads/karyawan/'.$d->foto);
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration + $karyawan->firstItem() -1 }}</td>
                                    <td>{{ $d-> nik}}</td>
                                    <td>{{ $d-> nama_lengkap}}</td>
                                    <td>{{ $d-> jabatan }}</td>
                                    <td>{{ $d-> nama_dep}}</td>
                                    <td>{{ $d-> no_hp}}</td>
                                    <td>
                                        @if (empty($d->foto))
                                            <img src="{{ asset('assets/img/nophoto.jpg')}}" class="avatar" alt="">
                                        @else
                                            <img src="{{ url($path)}}" class="avatar" alt="">
                                        @endif
                                        
                                    </td>
                                    <td></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $karyawan->links('vendor.pagination.bootstrap-5')}}
                        </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <h5 class="modal-title">Tambah data karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          
        </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('myscript')
    <script>
$(function(){
    $("#btnTambahkaryawan").click(function(){
        $("#modal-inputkaryawan").modal('show');
    });
});
    </script>
@endpush