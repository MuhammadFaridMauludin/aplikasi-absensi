<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-Absensi</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset ('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset ('assets/img/icon/192x192.png')}}">
    <link rel="stylesheet" href="{{ asset ('assets/css/style.css')}}">
    <link rel="manifest" href="__manifest.json">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0" style="background: #f4f7fa; min-height: 100vh; display: flex; align-items: center; justify-content: center;">

        <div class="login-form" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">

            <div class="section text-center mb-0">
                <img src="{{ asset ('assets/img/sample/photo/evergreen.png')}}" alt="image" class="form-image" style="width: 150px;">
            </div>
            <div class="section mt-1">
                <h1 class="mt-1" style="font-size: 1.8rem;">Get started</h1>
                <h4 style="color: #888;">Fill the form to log in with nik and password</h4>
            </div>
            @php 
            $messagewarning = Session::get('warning');
            @endphp
            @if (Session::get('warning'))
            <div class="alert alert-outline-warning">
                {{ $messagewarning }}
                <div>
            @endif
            <form action="/proseslogin" method="POST">
                @csrf
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="nik" class="form-control" id="nik" placeholder="NIK">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="password" name="password"placeholder="Password">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-links mt-2 mb-2">
                    <div><a href="page-forgot-password.html" class="text-muted">Forgot Password?</a></div>
                </div>
                <button type="submit" class="btn btn-block btn-lg" style="background-color: #d32f2f; border-color: #b71c1c; color: white; padding: 0.75rem; border-radius: 0.5rem;">Log in</button>
            </form>
        </div>
    </div>
    <!-- * App Capsule -->



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js')}}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js')}}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js')}}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js')}}"></script>


</body>

</html>