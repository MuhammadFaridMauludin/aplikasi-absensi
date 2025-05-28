@extends('layouts.presensi')

@section('content')

<div
        class="section"
        id="user-section"
        style="background: linear-gradient(135deg, #4c6ef5, #5f27cd)"
      >
        <div id="user-detail">
          <div class="avatar">
            {{-- 
          @if (!empty(Auth::guard('karyawan')->user()->foto))
              @php
                  $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
              @endphp

              <img
                  src="{{ url($path) }}"
                  alt="avatar"
                  class="imaged w64 rounded"
                  style="height: 60px;"
              />
          @endif 
          --}}
            @php
            $user = Auth::guard('karyawan')->user();
            $foto = $user->foto ?? null;
            $path = $foto ? Storage::url('uploads/karyawan/' . $foto) : asset('assets/img/nophoto.jpg');
            @endphp

            <img
                src="{{ url($path) }}"
                alt="avatar"
                class="imaged w64 rounded"
                style="height: 60px;"
            />        
            {{-- <img
              src="assets/img/sample/avatar/avatar1.jpg"
              alt="avatar"
              class="imaged w64 rounded"
            /> --}}
          </div>
          <div id="user-info">
            <h2 id="user-name">{{Auth::guard('karyawan')->user()->nama_lengkap}}</h2>
            <span id="user-role">{{Auth::guard('karyawan')->user()->jabatan}}</span>
          </div>
        </div>
      </div>

      <div class="section" id="menu-section">
        <div
          class="card"
          style="
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(35px);
            border-radius: 1rem;
            border: 1px solid white;
          "
        >
          <div class="card-body text-center">
            <div class="list-menu">
              <div class="item-menu text-center">
                <div class="menu-icon">
                  <a href="/editprofile" class="green" style="font-size: 40px">
                    <ion-icon
                      name="person"
                      style="color: #718096 !important"
                    ></ion-icon>
                  </a>
                </div>
                <div class="menu-name">
                  <span class="text-center">Profil</span>
                </div>
              </div>
              <div class="item-menu text-center">
                <div class="menu-icon">
                  <a href="/presensi/izin" class="danger" style="font-size: 40px">
                    <ion-icon
                      name="calendar-number"
                      style="color: #718096 !important"
                    ></ion-icon>
                  </a>
                </div>
                <div class="menu-name">
                  <span class="text-center">Cuti</span>
                </div>
              </div>
              <div class="item-menu text-center">
                <div class="menu-icon">
                  <a href="/presensi/history" class="warning" style="font-size: 40px">
                    <ion-icon
                      name="time"
                      style="color: #718096 !important"
                    ></ion-icon>
                  </a>
                </div>
                <div class="menu-name">
                  <span class="text-center">Histori</span>
                </div>
              </div>
              <div class="item-menu text-center">
                <div class="menu-icon">
                  <a href="" class="orange" style="font-size: 40px">
                    <ion-icon
                      name="location"
                      style="color: #718096 !important"
                    ></ion-icon>
                  </a>
                </div>
                <div class="menu-name">Lokasi</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
          <div class="row">
            <div class="col-6">
              <div class="card gradasigreen">
                <div class="card-body">
                  <div class="presencecontent">
                    <div class="iconpresence">
                      <ion-icon name="camera"></ion-icon>
                       {{-- menampilkan gambar jika perlu
                    @if($presensihariini != null)
                        @php
                            $path = Storage::url('uploads/absensi'.$presensihariini->foto_in);
                        @endphp
                        <img src="{{ url($path)}}" alt="" class="imaged w64">
                    @endif 
                    --}}

                    </div>
                    <div class="presencedetail">
                      <h4 class="presencetitle">Masuk</h4>
                      <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen'}}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card gradasiyellow">
                <div class="card-body">
                  <div class="presencecontent">
                    <div class="iconpresence">
                      <ion-icon name="camera"></ion-icon>
                      {{-- menampilkan gambar jika perlu
                    @if($presensihariini != null && $presensihariini-> jam_out !=null)
                        @php
                            $path = Storage::url('uploads/absensi'.$presensihariini->foto_out);
                        @endphp
                        <img src="{{ url($path)}}" alt="" class="imaged w64">
                    @endif 
                    --}}
                    </div>
                    <div class="presencedetail">
                      <h4 class="presencetitle">Pulang</h4>
                      <span>{{ $presensihariini != null && $presensihariini -> jam_out != null ?  $presensihariini->jam_out : 'Belum Absen' }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="rekappresence">
          <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} tahun {{$tahunini }}</h3>
<div class="row">
  <div class="col-3">
    <div class="card">
      <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
        <span class="badge bg-danger " style="position: absolute; top: 4px; right: 5px; z-index:999;">{{ $rekappresensi -> jmlhadir }}</span>
        <ion-icon name="accessibility-sharp" style="font-size: 3rem;" class="text-primary mb-1"></ion-icon>
        <br>
        <span style="font-size: 1.3rem; font-weight:500" class="mt-1">hadir</span>
      </div>
    </div>
  </div>
   <div class="col-3">
    <div class="card">
      <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
        <span class="badge bg-danger " style="position: absolute; top: 4px; right: 5px; z-index:999;">{{$rekapizin->jmlizin}}</span>
        <ion-icon name="mail-sharp" style="font-size: 3rem;" class="text-success mb-1"></ion-icon>
        <br>
        <span style="font-size: 1.3rem; font-weight:500" class="mt-1">izin</span>
      </div>
    </div>
  </div>
   <div class="col-3">
    <div class="card">
      <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
        <span class="badge bg-danger " style="position: absolute; top: 4px; right: 5px; z-index:999;">{{$rekapizin->jmlsakit}}</span>
        <ion-icon name="thermometer-sharp" style="font-size: 3rem;" class="text-warning mb-1"></ion-icon>
        <br>
        <span style="font-size: 1.3rem; font-weight:500" class="mt-1">sakit</span>
      </div>
    </div>
  </div>
 <div class="col-3">
    <div class="card">
      <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
        <span class="badge bg-danger " style="position: absolute; top: 4px; right: 5px; z-index:999;">{{ $rekappresensi -> jmlterlambat }}</span>
        <ion-icon name="time-sharp" style="font-size: 3rem;" class="text-danger mb-1"></ion-icon>
        <br>
        <span style="font-size: 1.3rem; font-weight:500" class="mt-1">terlambat</span>
      </div>
    </div>
  </div>
</div>
     </div>
        <div class="presencetab mt-2">
          <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                >
                  Bulan Ini
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#profile"
                  role="tab"
                >
                  Leaderboard
                </a>
              </li>
            </ul>
          </div>
          <div class="tab-content mt-2" style="margin-bottom: 100px">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
              <ul class="listview image-listview">
                @foreach ($historybulanini as $d)
               @php
               $path =Storage::url('uploads/absensi/' .$d->foto_in);
               @endphp
                     <li>
                  <div class="item">
                    <div class="icon-box bg-primary">
                     
                        <ion-icon
                          name="finger-print"
                          role="img"
                          class="md hydrated"
                          aria-label="image outline"
                        ></ion-icon>
                         <!--
                        <img src="{{ url($path)}}" alt="" class="image w64">
-->
                    </div>
                    <div class="in">
                      <div>{{ date("d-m-y" ,strtotime($d->tgl_presensi)) }}</div>
                      <span class="badge badge-success">{{ $d->jam_in }}</span>
                      <span class="badge badge-warning">{{$presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</span>
                    </div>
                  </div>
                </li>
                @endforeach
               
                
              </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
              <ul class="listview image-listview">
                @foreach ($leaderboard as $d)
                     <li>
                  <div class="item">
                    <img
                      src="assets/img/sample/avatar/avatar1.jpg"
                      alt="image"
                      class="image"
                    />
                    <div class="in">
                      <div>
                        <b>{{$d->nama_lengkap}}</b>
                        <br>
                        <small class="text-muted">{{$d->jabatan }}</small>
                      </div>
                      <span class="badge {{ $d->jam_in < "07.00" ? "bg-success" : "bg-danger"}}">{{$d->jam_in}}</span>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
@endsection