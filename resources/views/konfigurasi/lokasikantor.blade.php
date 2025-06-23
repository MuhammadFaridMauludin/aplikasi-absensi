@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Konfigurasi Lokasi</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
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
                        <form action="/konfigurasi/updatelokasikantor" method="POST">
                            @csrf 
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"/>
                                                <path d="M9 4v13"/>
                                                <path d="M15 7v5.5"/>
                                                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0
                                                         c.418 .419 1.125 1.045 2.121 1.879
                                                         c1.051 -.89 1.759 -1.516 2.121 -1.879z"/>
                                                <path d="M19 18v.01"/>
                                            </svg>
                                        </span>
                                        <input type="text" id="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor}}" class="form-control"
                                               placeholder="Lokasi Kantor" name="lokasi_kantor">
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-icon mb-3">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="icon icon-tabler icons-tabler-outline icon-tabler-radar">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M21 12h-8a1 1 0 1 0 -1 1v8a9 9 0 0 0 9 -9"/>
                                                        <path d="M16 9a5 5 0 1 0 -7 7"/>
                                                        <path d="M20.486 9a9 9 0 1 0 -11.482 11.495"/>
                                                    </svg>
                                                </span>
                                                <input type="text" id="radius" value="{{ $lok_kantor->radius}}" class="form-control"
                                                       placeholder="Radius" name="radius">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M11 18.004h-4.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487
                                                     c0 -2.475 2.085 -4.482 4.657 -4.482
                                                     c.393 -1.762 1.794 -3.2 3.675 -3.773
                                                     c1.88 -.572 3.956 -.193 5.444 1
                                                     c1.488 1.19 2.162 3.007 1.77 4.769h.99
                                                     c1.388 0 2.585 .82 3.138 2.007"/>
                                            <path d="M15 19l2 2l4 -4"/>
                                        </svg>
                                        Update
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col-6 -->
        </div> <!-- row -->
    </div> <!-- container-xl -->
</div> <!-- page-body -->
@endsection
