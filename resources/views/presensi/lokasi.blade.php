@extends('layouts.presensi')

@section('header')
    <div class="appHeader text-light" style="background-color: #d32f2f">
        <div class="left">
            <a href="{{ url('/dashboard')}}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Lokasi</div>
        <div class="right"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        #map {
            height: 550px;
        }
    </style>
@endsection

@section('content')
<div class="row" style="margin-top: 60px">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('myscript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // Atur icon marker agar tidak error
                delete L.Icon.Default.prototype._getIconUrl;
                L.Icon.Default.mergeOptions({
                    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                });

                var map = L.map('map').setView([lat, lng], 15);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup("Lokasi Anda")
                    .openPopup();

                setTimeout(() => map.invalidateSize(), 200);

            }, function (error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    });
</script>
@endpush