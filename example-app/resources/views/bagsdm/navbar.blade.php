<body class="sb-nav-fixed">
    <style>
    .sb-sidenav-light {
        background-color: #ffffff !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100vh;
        border-right: 1px solid #dee2e6; 
    }

    .sb-sidenav-light .sb-sidenav-menu .nav-link {
        color: #6c757d !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .sb-sidenav-light .sb-sidenav-menu .nav-link:hover,
    .sb-sidenav-light .sb-sidenav-menu .nav-link:focus {
        background-color: #d4edda !important;
        color: #198754 !important;
    }

    .sb-sidenav-light .sb-nav-link-icon {
        color: #adb5bd !important;
    }

    .sb-sidenav-light .sb-sidenav-menu-heading {
        color: #6c757d !important;
        font-weight: bold;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .social-footer {
        padding: 1rem 0;
        text-align: center;
        border-top: 1px solid #e0e0e0;
        background-color: #f8f9fa;
    }

    .social-icon {
        color: #6c757d;
        margin: 0 10px;
        transition: transform 0.2s, color 0.2s;
    }

    .social-icon:hover {
        color: #198754 !important;
        transform: scale(1.2);
    }

    main .container-fluid {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }

    @media (min-width: 768px) {
        main .container-fluid {
            margin-left: 1.5rem;
        }
    }
</style>

<!-- Top Navbar -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
    <a class="navbar-brand ps-3 text-white d-flex align-items-center gap-2" href="{{ route('dashboard.bagsdm') }}">
        <img src="http://ptpn6.com/templates/layout2020/assets/img/regional_4.png" alt="Logo" width="30" height="30">
        EVENT MONITORING
    </a>

    <!-- Spacer to push logout to the right -->
    <div class="ms-auto d-flex align-items-center pe-3">
        <form action="/logout" method="POST" class="mb-0">
            @csrf
            <button class="btn btn-success text-white border-0" type="submit" title="Logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>
</nav>

    <!-- Sidebar & Content -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <!-- Sidebar Menu -->
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Bagian SDM</div>
                        <a class="nav-link" href="{{ route('dashboard.bagsdm') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="{{ route('formDataPeserta') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-book-open"></i></div>
                            Daftar Peserta
                        </a>
                        <a class="nav-link" href="{{ route('formDataKaryawan') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Daftar Karyawan
                        </a>
                        <a class="nav-link" href="{{ route('bagsdm.formPelatihan') }}">
                             <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                             Daftar Pelatihan
                        </a>
                    </div>
                </div>

                <!-- Sidebar Footer: Social Media -->
                <div class="social-footer">
                    <a href="https://www.facebook.com/share/16kLLdjQ58/" target="_blank" class="social-icon">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/ptpn4_regional4?igsh=MXQ3Ymg1NG83Nmd3aw==" target="_blank" class="social-icon">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="http://www.ptpn6.com/" target="_blank" class="social-icon">
                        <i class="fas fa-globe fa-lg"></i>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    {{-- Judul dan Breadcrumb --}}
                    <h1 class="mt-4"></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"></li>
                    </ol>

                    {{-- Konten halaman --}}
                    @yield('content')

                </div>
            </main>
        </div>
    </div>
</body>
