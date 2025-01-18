<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil->nama_perusahaan }} | @yield('title')</title>



    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('themplete/back') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/jqvmap/jqvmap.min.css">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/daterangepicker/daterangepicker.css">

    <!-- Google Font: Source Sans Pro -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('themplete/back') }}/plugins/summernote/summernote-bs4.min.css">
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="https://sistemakademik.ltpresent.com/upload/profil/logo_1714364503.png"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="/upload/profil/{{ $profil->favicon }}">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('themplete/back') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('themplete/back') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('themplete/back') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <style>
        /* CSS untuk menyembunyikan div saat mencetak */
        @media print {
            #unhide {
                display: none;
            }
        }
    </style>


    @stack('css')


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            {{-- <img class="animation__shake" src="" alt="Master" height="60" width="60" id="preloaderLogo"> --}}
            <img class="animation__shake" src="/upload/profil/{{ $profil->logo }}" alt="Master"
                height="100" width="100" id="preloaderLogo">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://wa.me/628971033234" class="nav-link">Kontak Person</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" target="_blank" class="nav-link">Lihat Website</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" style="color: rgb(5, 5, 5);">
                        <span>({{ Auth::user()->role }})</span>
                    </a>

                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" style="color: red;">
                        <i class="far fa-envelope"></i> <b>Kontak Masuk
                        </b>
                    </a>

                </li> --}}

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="/logout" class="nav-link" style="color: red;">
                        <i class="nav-icon fas fa-undo"></i> <b>Logout
                        </b>
                    </a>

                </li>

            </ul>
        </nav>
        <!-- /.navbar -->


        {{-- Sidebar --}}
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">

                <img src="/upload/profil/{{ $profil->favicon }}" alt=""
                    class="brand-image img-circle elevation-3" {{-- <img src="/upload/profil/{{ $profil->logo }}" alt="" class="brand-image img-circle elevation-3" --}} style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $profil->nama_perusahaan }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">

                        <img src="{{ asset('themplete/back') }}/dist/img/avatar.png" class="img-circle elevation-2"
                            alt="User Image">

                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>




                <?php
                // Dapatkan path URL saat ini
                $currentPath = $_SERVER['REQUEST_URI'];
                ?>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link <?php echo $currentPath == '/dashboard' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>




                        <li class="nav-header">Master</li>
                        {{-- <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_produk') !== false || strpos($currentPath, '/produk') !== false ? 'menu-open active' : ''; ?> ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Data Produk
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="/kategori_produk" class="nav-link <?php echo $currentPath == '/kategori_produk' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori Produk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/produk" class="nav-link <?php echo $currentPath == '/produk' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Produk</p>
                                    </a>
                                </li>


                            </ul>
                        </li> --}}
                        <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_berita') !== false || strpos($currentPath, '/berita') !== false ? 'menu-open active' : ''; ?> ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-blog"></i>
                                <p>
                                    Data Berita
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="/kategori_berita" class="nav-link <?php echo $currentPath == '/kategori_berita' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/berita" class="nav-link <?php echo $currentPath == '/berita' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Berita</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_galeri') !== false || strpos($currentPath, '/galeri') !== false ? 'menu-open active' : ''; ?> ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-film"></i>
                                <p>
                                    Data Galeri
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="/kategori_galeri" class="nav-link <?php echo $currentPath == '/kategori_galeri' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori Galeri</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/galeri" class="nav-link <?php echo $currentPath == '/galeri' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Galeri</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="nav-item 

                           <?php echo strpos($currentPath, '/bbu') !== false || strpos($currentPath, '/ptbu') !== false || strpos($currentPath, '/bbptu') !== false || strpos($currentPath, '/imt') !== false ? 'menu-open active' : ''; ?> ">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-thermometer"></i>
                                <p>
                                    Data Rumus
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="/bbu" class="nav-link <?php echo $currentPath == '/bbu' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>BB/U</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/ptbu" class="nav-link <?php echo $currentPath == '/ptbu' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>PB ATAU TB /U</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/bbptu" class="nav-link <?php echo $currentPath == '/bbptu' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>BB / PB ATAU TB</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/imt" class="nav-link <?php echo $currentPath == '/imt' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>IMT</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/slider" class="nav-link <?php echo $currentPath == '/slider' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-images"></i>

                                <p>
                                    Slider
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/video" class="nav-link <?php echo $currentPath == '/video' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-video"></i>

                                <p>
                                    Video
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/layanan" class="nav-link <?php echo $currentPath == '/layanan' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-list"></i>

                                <p>
                                    Layanan
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="/alasan" class="nav-link <?php echo $currentPath == '/alasan' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-feather"></i>

                                <p>
                                    Alasan
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/testimoni" class="nav-link <?php echo $currentPath == '/testimoni' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-paper-plane"></i>

                                <p>
                                    Testimoni
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="/pengguna" class="nav-link <?php echo $currentPath == '/pengguna' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-users"></i>

                                <p>
                                    Pengguna
                                </p>
                            </a>
                        </li> --}}
                      
                        <li class="nav-item">
                            <a href="/data_kpsp" class="nav-link <?php echo $currentPath == '/data_kpsp' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-shopping-cart"></i>

                                <p>
                                   Pertanyaan KPSP
                                </p>
                            </a>
                        </li>  
                        <li class="nav-item">
                            <a href="/hasil_hitung" class="nav-link <?php echo $currentPath == '/hasil_hitung' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-shopping-bag"></i>

                                <p>
                                    Hasil Hitung Gizi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/hasil_kpsp" class="nav-link <?php echo $currentPath == '/hasil_kpsp' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-calculator"></i>

                                <p>
                                    Hasil Hitung KPSP
                                </p>
                            </a>
                        </li>






                        <li class="nav-header">Pengaturan</li>
                        <li class="nav-item">
                            <a href="/profil/1/edit" class="nav-link <?php echo $currentPath == '/profil/1/edit' ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    Profil Umum
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link <?php echo $currentPath == '/users' ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/backup_database" class="nav-link <?php echo $currentPath == '/backup_database' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Back Up Database
                                </p>
                            </a>
                        </li> --}}




                        {{-- <li class="nav-item">
                            <a href="{{ route('backup.run') }}" class="nav-link">
                                <i class="nav-icon fas fa-database"></i>
                                <p>Run Backup</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ route('log_histori.index') }}" class="nav-link <?php echo $currentPath == '/log_histori' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Log Histori
                                </p>
                            </a>
                        </li>



                        {{-- <li class="nav-header">Laporan</li>

                        <li class="nav-item 
                        <?php echo strpos($currentPath, '/laporan/guru') !== false || strpos($currentPath, '/laporan/siswa') !== false || strpos($currentPath, '/laporan/kelas') !== false ? 'menu-open active' : ''; ?> ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" class="nav-link <?php echo $currentPath == '/laporan/guru' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Guru</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/siswa' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Siswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/kelas' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kelas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item 
                        <?php echo strpos($currentPath, '/laporan/nilai_siswa') !== false || strpos($currentPath, '/tampilkan-jadwal') !== false || strpos($currentPath, '/laporan/absensi') !== false ? 'menu-open active' : ''; ?> ">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Akademik
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/nilai_siswa' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nilai Siswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">

                                    <a href="/tampilkan-jadwal" class="nav-link <?php echo $currentPath == '/tampilkan-jadwal' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jadwal Pelajaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/absensi' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Absensi</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item 
                        <?php echo strpos($currentPath, '/laporan/keuangan') !== false || strpos($currentPath, '/laporan/surat') !== false || strpos($currentPath, '/laporan/barang') !== false || strpos($currentPath, '/laporan/mutasi_barang') !== false ? 'menu-open active' : ''; ?> ">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Transaksi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/keuangan' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Keuangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/surat' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Administrasi Surat</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/barang' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Aset Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" " class="nav-link <?php echo $currentPath == '/laporan/mutasi_barang' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mutasi Aset Barang</p>
                                    </a>
                                </li>


                            </ul>
                        </li> --}}














                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        {{-- Akhir Sidebar --}}


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">@yield('subtitle')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    @yield('content')


                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <footer class="main-footer" id="unhide">
        All Rights Reserved by Layla Techno &copy; {{ date('Y') }}. Designed and Developed by <a
            href="https://www.ltpresent.com">Layla Techno</a>.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>


    <!-- jQuery -->
    <script src="{{ asset('themplete/back') }}/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('themplete/back') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>


    <!-- Sparkline -->
    <script src="{{ asset('themplete/back') }}/plugins/sparklines/sparkline.js"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('themplete/back') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->

    <script src="{{ asset('themplete/back') }}/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('themplete/back') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->

    <script src="{{ asset('themplete/back') }}/plugins/moment/moment.min.js"></script>


    </script>
    <!-- Summernote -->
    <script src="{{ asset('themplete/back') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('themplete/back') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('themplete/back') }}/dist/js/adminlte.js"></script>


    <script src="{{ asset('themplete/back') }}/plugins/chart.js/Chart.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('themplete/back') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>




    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [5, 10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // Tambahkan konfigurasi untuk example4 yang sama dengan example1
            $("#example4").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
        });
    </script>




    @stack('scripts')

</body>

</html>
