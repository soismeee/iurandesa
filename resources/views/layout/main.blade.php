<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dindagkop dan UKM" name="description" />
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
    @stack('css')
</head>
<body data-sidebar="colored">

    <!-- Begin page -->
    <div id="layout-wrapper">
        
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="/" class="logo logo-dark">
                            <span class="logo-sm">
                                IW
                            </span>
                            <span class="logo-lg">
                                IW
                            </span>
                        </a>
                        
                        <a href="/" class="logo logo-light">
                            <span class="logo-sm">
                                IW
                            </span>
                            <span class="logo-lg">
                                IW
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- start page title -->
                    <div class="page-title-box align-self-center d-none d-md-block">
                        <h4 class="page-title mb-0">{{ $title }}</h4>
                    </div>
                    <!-- end page title -->
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-account-circle-line"></i>
                            {{-- <span class="noti-dot"></span> --}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Pengaduan </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> Lihat semua</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-newspaper-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Pengaduan baru</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="/pengaduan">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> Lihat lainnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        @include('layout.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
        
                    @yield('container')
                    <div class="modal logout" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modal keluar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Anda akan keluar dari aplikasi</h5>
                                </div>
                                <div class="modal-footer">
                                    <a href="/logout" class="btn btn-primary waves-effect waves-light">Ya, keluar</a>
                                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Sapa Daku.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i> Dindagkop dan UKM
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
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
    @stack('js')
</body>
</html>