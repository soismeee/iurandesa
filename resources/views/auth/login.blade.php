<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sapa Daku" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/img/sapadaku/icon-01.ico">

        <!-- Layout Js -->
        <script src="/tocly/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="/tocly/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/tocly/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/tocly/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="auth-maintenance d-flex align-items-center min-vh-100">
            <div class="bg-overlay bg-light"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                    <div class="text-center mb-4">
                                        <a href="index.html" class="">
                                            <img src="/assets/img/sapadaku/Logo.png" alt="" height="44" class="auth-logo logo-dark mx-auto">
                                            <img src="/assets/img/sapadaku/Logo.png" alt="" height="44" class="auth-logo logo-light mx-auto">
                                        </a>
                                        <p class="mt-2">Sistem iuran warga</p>
                                    </div>
    
                                    <div class="card my-auto overflow-hidden">
                                        <div class="row g-0">
                                            <div class="col-lg-12">
                                                <div class="p-lg-5 p-4">
                                                    <div>
                                                        <div class="text-center mt-1">
                                                            <h4 class="font-size-18">Welcome Back !</h4>
                                                            <p class="text-muted">Sign in to continue to Sapa Daku.</p>
                                                        </div>
        
                                                        <form action="/auth" method="POST" id="form-login" class="auth-input">
                                                            @csrf
                                                            <div class="mb-2">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="password-input">Password</label>
                                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                                            </div>
                                                            <div class="mt-3">
                                                                <button class="btn btn-primary w-100" type="submit" id="tombol">Sign In</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                
                                                    <div class="mt-4 text-center">
                                                        <p>Pekalongan</p>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <!-- end card -->
                                    
                                    <div class="mt-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Iuran Warga. Crafted with <i class="mdi mdi-heart text-danger"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
        
        <!-- JAVASCRIPT -->
        <script src="/tocly/libs/jquery/jquery.min.js"></script>
        <script src="/tocly/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/tocly/libs/metismenu/metisMenu.min.js"></script>
        <script src="/tocly/libs/simplebar/simplebar.min.js"></script>
        <script src="/tocly/libs/node-waves/waves.min.js"></script>

        <!-- Icon -->
        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

        <script src="/tocly/js/app.js"></script>
        <script>
            $(document).on('submit', '#form-login', function(e) {
                e.preventDefault();
                $('#tombol').prop('disabled', true);
                $('#tombol').html('Loading...')
    
                $.ajax({
                    type: "POST",
                    url: "{{ url('aksilogin') }}",
                    data: $('#form-login').serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#tombol').prop('disabled', false);
                        // $('#tombol').html('Sign In');
                        window.location.href = "{{ url('/home') }}";
                    },
                    error: function(err) {
                        $('#tombol').prop('disabled', false);
                        $('#tombol').html('Sign In');
                        let error = err.responseJSON;
                        $.each(error.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                        });
                    }
                });
            });
        </script>
    </body>
</html>
