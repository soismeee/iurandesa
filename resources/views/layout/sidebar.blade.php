<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                IW    
            </span>
            <span class="logo-lg text-white">
                IURAN WARGA
            </span>
        </a>

        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                IW    
            </span>
            <span class="logo-lg text-white">
                IURAN WARGA
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn" id="vertical-menu-btn">
        <i class="ri-menu-2-line align-middle"></i>
    </button>

    <div data-simplebar class="vertical-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="/home" class="waves-effect">
                        <i class="uim uim-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="menu-title">Master</li>
                <li>
                    <a href="/kategori" class="waves-effect">
                        <i class="uim uim-layer-group"></i>
                        <span>Kategori Iuran</span>
                    </a>
                </li>
                <li>
                    <a href="/warga" class="waves-effect">
                        <i class="uim uim-layer-group"></i>
                        <span>Data Warga</span>
                    </a>
                </li>
                <li class="menu-title">Data</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim uim-bag"></i>
                        <span>Iuran</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li><a href="/input_iuran">Input Iuran</a></li>
                        <li><a href="/daftar_iuran">Daftar Iuran</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/rekap_iuran" class="waves-effect">
                        <i class="uim uim-graph-bar"></i>
                        <span>Rekap Iuran</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect" data-bs-toggle="modal" data-bs-target=".logout">
                        <i class="uim uim-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="dropdown px-3 sidebar-user sidebar-user-info">
        <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="/tocly/images/users/avatar-2.jpg" class="img-fluid header-profile-user rounded-circle" alt="">
                </div>

                <div class="flex-grow-1 ms-2 text-start">
                    <span class="ms-1 fw-medium user-name-text">Iuran Warga</span>
                </div>

                <div class="flex-shrink-0 text-end">
                    <i class="mdi mdi-dots-vertical font-size-16"></i>
                </div>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <a class="dropdown-item" href="/pages/profile"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
        </div>
    </div>

</div>