  <!-- App Bottom Menu -->
  <div class="appBottomMenu">
        <a href="/dashboard" class="item {{ request()-> is ('dashboard') ? 'active' : ''}}">
            <div class="col">
                <ion-icon
                    name="sunny-outline"
                    role="img"
                    class="md hydrated"
                    aria-label="file tray full outline"></ion-icon>
                <strong>Today</strong>
            </div>
        </a>
        <a href="/presensi/history" class="item {{ request()-> is ('presensi/history') ? 'active' : ''}}">
            <div class="col">
                <ion-icon
                    name="time-outline"
                    role="img"
                    class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>history</strong>
            </div>
        </a>
        <a href="/presensi/create" class="item">
            <div class="col" >
                <div class="action-button large" style="background-color: #d32f2f">
                    <ion-icon
                        name="camera"
                        role="img"
                        class="md hydrated"
                        aria-label="add outline" ></ion-icon>
                </div>
            </div>
        </a>
        <a href="/presensi/izin" class="item {{ request()-> is ('presensi/izin') ? 'active' : ''}}">
            <div class="col" >
                <ion-icon
                    name="calendar-outline"
                    role="img"
                    class="md hydrated"
                    aria-label="calendar outline" ></ion-icon>
                <strong>Cuti</strong>
            </div>
        </a>
        
        <a href="/editprofile" class="item {{ request()-> is ('editprofile') ? 'active' : ''}}">
            <div class="col">
                <ion-icon
                    name="person-outline"
                    role="img"
                    class="md hydrated"
                    aria-label="people outline"></ion-icon>
                <strong>Profil</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->