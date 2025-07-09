@extends('layouts.presensi')
@section('header')
   <!-- app header-->
    <div class="appHeader text-light" style="background-color: #d32f2f">
        <div class="left">
            <a href="{{ url('/dashboard')}}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Izin</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
        @endphp
        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ $messagesuccess }}
        </div>
        @endif
        @if(Session::get('error'))
        <div class="alert alert-danger">
            {{ $messageerror }}
        </div>
        @endif 
    </div>
</div>
<div class="row">
   <div class="col">
     @foreach ($dataizin as $d)
   <ul class="listview image-listview">
    <li>
                  <div class="item">
                    <div class="in">
                      <div>
                        <b>{{date("d-m-Y", strtotime($d->tgl_izin)) }} ({{$d->status== "s" ? "Sakit" : "Izin"}})</b>
                        <br>
                        <small class="text-muted">{{ $d->alasan }}</small>
                      </div>
                      @if ($d->status_approved==0)
                      <span class="badge bg-warning">menunggu</span>
                      @elseif($d->status_approved==1)
                      <span class="badge bg-success">disetujui</span>
                      @elseif($d->status_approved==2)
                      <span class="badge bg-danger">ditolak</span>
                      @endif
                    </div>
                  </div>
                </li>
   </ul>
@endforeach
   </div>
</div>
<div class="fab-button bottom-right" style="margin-bottom: 65px;">
    <a href="/presensi/pengajuanizin" class="fab" style="background-color: #d32f2f;" >
        <ion-icon name="add"></ion-icon>
    </a>
</div>
@endsection
