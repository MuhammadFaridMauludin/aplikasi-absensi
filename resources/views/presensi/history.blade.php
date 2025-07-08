@extends('layouts.presensi')
@section('header')
   <!-- app header-->
    <div class="appHeader text-light" style="background-color: #d32f2f">
        <div class="left">
            <a href="{{ url('/dashboard')}}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History Presensi</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top:70px;">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @for ($i=1; $i<=12; $i++) <option value="{{$i}}" {{date("m") == $i ? 'selected' : ''}}>{{ $nama_bulan[$i] }}</option>
                            
                                
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
                            @php
                            $tahunmulai = 2024;
                            $tahunskrng = date("Y");
                            @endphp
                            @for($tahun = $tahunmulai; $tahun <= $tahunskrng; $tahun++)
                            <option value="{{ $tahun }}" {{date("Y") == $tahun ? 'selected' : ''}}>{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-block text-white" style="background-color: #d32f2f" id="getdata">
                        <ion-icon name="search-sharp"></ion-icon> Cari
                        </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="showhistory">

    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function(){
            $("#getdata").click(function(e){
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type:'POST',
                    url:'/gethistory',
                    data:{
                        _token: "{{ csrf_token()}}",
                        bulan:bulan,
                        tahun:tahun
                    },
                    cache:false,
                    success:function(respond){
                       $("#showhistory").html(respond);
                    }
                });
            });
        });
    </script>
@endpush