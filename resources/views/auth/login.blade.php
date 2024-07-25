<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Magang</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin-dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-dashboard/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin-dashboard/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/admin-dashboard/images/LogoTypeSV-01.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-center py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/admin-dashboard/images/LogoSV.png') }}" alt="logo">
                            </div>
                            <h4>Silahkan login menggunakan akun yang terdaftar</h4>
                            <h6 class="font-weight-light">Masukkan email dan password anda</h6>
                            <form class="user" method="POST" action="{{ route('prosesLogin') }}">
                                @csrf
                                <form class="pt-3">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" id="email"
                                            aria-describedby="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Masukkan Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="password"
                                            aria-describedby="password"
                                            class="form-control  @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password"
                                            placeholder="Masukkan Paswword">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit"
                                            class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                                    </div>
                                    @session('error')
                                        <div class="mt-3 btn btn card card-light-danger">
                                            Akun tidak aktif atau tidak ditemukan
                                        </div>
                                    @endsession
                                    <div class="text-center mt-4 font-weight-light">
                                        Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Buat
                                            Akun</a>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/admin-dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('assets/admin-dashboard/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/admin-dashboard/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/admin-dashboard/js/template.js') }}"></script>
    <script src="{{ asset('assets/admin-dashboard/js/settings.js') }}"></script>
    <script src="{{ asset('assets/admin-dashboard/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
