@extends('layouts.presensi')
@section('header')

    <!-- App Header -->
    <div class="appHeader text-light" style="background-color: #d32f2f">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Absensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 200px;
    }

    .video-wrapper {
        position: relative;
        
        width: 100%;
    }

    #video-preview {
        width: 100%;
        border-radius: 15px;
        display: block;
    }

    #countdown {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 80px;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 10px black;
        z-index: 9999;
        display: none;
    }
</style>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">//librari untuk maps</script>
@endsection

@section('content')

<div class="row" style="margin-top: 60px">
    <div class="col">
        <!-- Input lokasi tersembunyi -->
        <input type="hidden" id="lokasi">

        <!-- Tampilan kamera -->
        <div class="webcam-capture"></div>
</div>
</div>
<div class="row">
    <div class="col">
<!-- Tombol Ambil Foto dan Video -->
<div class="text-center mt-1">
    <!-- Tombol Ambil Foto -->
    <button id="takeabsen" class="btn btn-block text-white" style="background-color: #d32f2f">
        <ion-icon name="camera"></ion-icon>
        {{ $cek > 0 ? 'Absen Pulang' : 'Absen Masuk' }}
    </button>
    <!-- Tombol Ambil Video (muncul setelah foto diambil) -->
    <div id="video-controls" class="mt-1" style="display: none;">
        <button id="start-video" class="btn btn-block text-white" style="background-color: #d32f2f">
            Ambil Video
        </button>
    </div>
</div>
        <!-- Wrapper untuk preview video dan countdown -->
        <div class="video-wrapper mt-1" id="preview-wrapper" style="display: none;">
            <video id="video-preview" controls></video>
            <div id="countdown">3</div>
        </div>
    </div>
</div>
    
<!-- Peta Lokasi -->
<div class="row mt-1">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<!-- Penambahan notifikasi pada absen -->
<audio id="ringtone1">
    <source src="{{ asset('assets/sound/ringtone1.mp3')}}" type="audio/mpeg">
</audio>
<audio id="ringtone2">
    <source src="{{ asset('assets/sound/ringtone2.mp3')}}" type="audio/mpeg">
</audio>
<audio id="radius">
    <source src="{{ asset('assets/sound/radius.mp3')}}" type="audio/mpeg">
</audio>
@endsection


@push('myscript')
<script>
    var ringtone1 = document.getElementById('ringtone1');
    var ringtone2 = document.getElementById('ringtone2');
    var radius = document.getElementById('radius');
    // Inisialisasi webcam
    Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });
    Webcam.attach('.webcam-capture');

    // Lokasi + Peta
    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(succesCallback, erorCallback);
    }

    function succesCallback(position) {
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 15);
        var lokasi_kantor = "{{ $lok_kantor->lokasi_kantor }}"
        var lok = lokasi_kantor.split(",");
        var lat_kantor =lok[0];
        var long_kantor = lok[1];
        var radius = "{{ $lok_kantor->radius }}";
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        L.circle([lat_kantor, long_kantor], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius,
        }).addTo(map);
    }

    function erorCallback() {
        alert("Gagal mendeteksi lokasi.");
    }

    let image = null;
    let videoBlob = null;
    let mediaRecorder;
    let recordedChunks = [];

    // Ambil foto saat tombol absen diklik
    $("#takeabsen").click(function () {
        Webcam.snap(function (uri) {
            image = uri;
            // tetap tampilkan kamera aktif
            $("#video-controls").show(); // tampilkan tombol Take Video
            $("#takeabsen").hide(); // sembunyikan tombol absen setelah ambil foto
        });
    });

    // Take video
    $("#start-video").click(async function () {
        await startCountdownAndRecord(); // countdown dan rekam
    });

    function startCountdown(callback) {
    const countdownElement = document.getElementById('countdown');
    let counter = 3;

    countdownElement.innerText = counter;
    countdownElement.style.display = 'block';

    const interval = setInterval(() => {
        counter--;
        if (counter > 0) {
            countdownElement.innerText = counter;
        } else {
            clearInterval(interval);
            countdownElement.style.display = 'none';
            callback(); // mulai rekam video
        }
    }, 1000);
}
async function startCountdownAndRecord() {
    $("#video-preview").hide();
    $("#preview-wrapper").show();
    $(".webcam-capture").show(); // tetap tampilkan kamera di belakang countdown
    startCountdown(async () => {
        $(".webcam-capture").show(); // setelah hitung mundur, sembunyikan kamera
        $("#video-preview").hide();  // tampilkan video preview saat selesai rekam
        await startRecording();
    });
}


async function startRecording() {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false }); // tanpa suara
    mediaRecorder = new MediaRecorder(stream);
    recordedChunks = [];

    mediaRecorder.ondataavailable = function (event) {
        if (event.data.size > 0) {
            recordedChunks.push(event.data);
        }
    };

mediaRecorder.onstop = function () {
    const blob = new Blob(recordedChunks, { type: "video/webm" });

    // Sembunyikan elemen video agar tidak muncul preview
    document.getElementById('video-preview').style.display = 'none';
    document.getElementById('preview-wrapper').style.display = 'none';

    videoBlobToBase64(blob, function (base64Video) {
        kirimAbsen(base64Video);
    });

    // stop all tracks untuk melepaskan kamera
    stream.getTracks().forEach(track => track.stop());
};


    mediaRecorder.start();
    setTimeout(() => {
        mediaRecorder.stop();
    }, 5000); // durasi video 5 detik
}


    function videoBlobToBase64(blob, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            callback(reader.result);
        };
    }

    function kirimAbsen(videoBase64) {
        const lokasi = $("#lokasi").val();

        $.ajax({
            type: "POST",
            url: "/presensi/store",
            data: {
                _token: "{{ csrf_token() }}",
                image: image,
                video: videoBase64,
                lokasi: lokasi
            },
            success: function (respond) {
                var status = respond.split("|");
                if (status[0] == "success") {
                    if(status[2] == "in"){
                        ringtone1.play();
                    }else{
                        ringtone2.play();
                    }
                   Swal.fire({
                    title: 'Berhasil',
                    text: status[1],
                    icon: 'success',
                    confirmButtonText: 'OK'
                    })
setTimeout("location.href='/dashboard'", 3000);
                } else {
                    if(status[2] == "radius"){
                        radius.play();
                    }
                     Swal.fire({
                        title: 'Erorr',
                        text: status[1],
                        icon: 'eror',
                        confirmButtonText: 'OK'
                        })
                }
            },
        });
    }
</script>
@endpush
