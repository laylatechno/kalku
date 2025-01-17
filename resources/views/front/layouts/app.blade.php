<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $metaDescription = $profil->deskripsi;
    $metaImage = asset('upload/profil/' . $profil->logo);
    $title = $title . ' - ' . $profil->nama_perusahaan;
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#15dc36">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:type" content="website">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('upload/profil/' . $profil->favicon) }}">
    <link rel="apple-touch-icon" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $metaImage }}">


    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('themplete/front') }}/style.css">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('themplete/front') }}/manifest.json">
    <style>
        @media print {

            /* Sembunyikan elemen dengan kelas 'unhide' saat mencetak */
            .unhide {
                display: none;
            }

            /* Atur margin halaman menjadi nol saat mencetak */
            @page {
                margin: 0;
            }

            /* Atur margin untuk body agar tidak terpotong */
            body {
                margin: 1cm;
            }
        }
    </style>
 






</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area unhide" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div
                class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <!-- Logo Wrapper -->
                <div class="logo-wrapper">
                    <a href="{{ asset('themplete/front') }}/home.html">
                        <img src="upload/profil/{{ $profil->logo }}" alt="">
                    </a>
                </div>

                <!-- Navbar Toggler -->
                <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas"
                    data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- # Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
        aria-labelledby="affanOffcanvsLabel">

        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

        <div class="offcanvas-body p-0">
            <div class="sidenav-wrapper">
                <!-- Sidenav Profile -->
                <div class="sidenav-profile bg-gradient">
                    <div class="sidenav-style1"></div>

                    <!-- User Thumbnail -->
                    <div class="user-profile">
                        <img src="/upload/profil/{{ $profil->logo }}" alt="">
                    </div>

                    <!-- User Info -->
                    <div class="user-info">
                        <h6 class="user-name mb-0">{{ $profil->nama_perusahaan }}</h6>
                        <span>{{ $profil->alamat }} - {{ $profil->no_telp }}</span>
                    </div>
                </div>

                <!-- Sidenav Nav -->
                <ul class="sidenav-nav ps-0">
                    <li>
                        <a href="/"><i class="bi bi-house-door"></i> Beranda</a>
                    </li>
                    {{-- <li>
            <a href=""><i class="bi bi-folder2-open"></i> Kebijakan
              <span class="badge bg-danger rounded-pill ms-2">Baru</span>
            </a>
          </li>
          <li>
            <a href=""><i class="bi bi-collection"></i> Syarat & Ketentuan
              <span class="badge bg-success rounded-pill ms-2">Baru</span>
            </a>
          </li> --}}
                    <li>
                        <a href="/galeri_pengguna"><i class="bi bi-newspaper"></i> Galeri
                        </a>
                    </li>
                    <li>
                        @php
                        $no_wa = str_replace(['-', ' ', '+'], '', $profil->no_wa); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
                        $pesan =
                        'Hallo.. !! Apakah berkenan saya bertanya terkait informasi tentang ' .
                        $profil->nama_perusahaan .
                        ' ?';
                        $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
                        $whatsapp_url = "https://wa.me/{$no_wa}?text={$encoded_pesan}"; // Membuat URL lengkap
                        @endphp

                        <a href="{{ $whatsapp_url }}"><i class="bi bi-phone"></i> Kontak</a>
                    </li>

                    <li>
                        <div class="night-mode-nav">
                            <i class="bi bi-moon"></i> Mode Gelap
                            <div class="form-check form-switch">
                                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                            </div>
                        </div>
                    </li>

                </ul>

                <!-- Social Info -->
                <div class="social-info-wrap">
                    <a href="{{ $profil->facebook }}">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ $profil->youtube }}">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="{{ $profil->instagram }}">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>

                <!-- Copyright Info -->
                <div class="copyright-info">
                    <p>
                        <span id="copyrightYear"></span>
                        &copy; Copyright <a href="#">{{ $profil->nama_perusahaan }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper">


        @yield('content')


        <div class="pb-3"></div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area unhide" id="footerNav">
        <div class="container px-0">
            <!-- Footer Content -->
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="/">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('hitung_gizi') ? 'active' : '' }}">
                        <a href="/hitung_gizi">
                            <i class="bi bi-calculator-fill"></i>
                            <span>Kalkulator <br> Gizi Anak</span>
                        </a>
                    </li>


                    <li class="{{ request()->is('kpsp*') ? 'active' : '' }}">
                        <a href="/kpsp">
                            <i class="bi bi-chat-right-quote-fill"></i>
                            <span>Cek <br> Perkembangan Anak</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('sras*') ? 'active' : '' }}">
                        <a href="/sras">
                            <i class="bi bi-thermometer-half"></i>
                            <span>Deteksi <br> Risiko Stunting</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('info*') ? 'active' : '' }}">
                        <a href="/info">
                            <i class="bi bi-info-square-fill"></i>
                            <span>Info</span>
                        </a>
                    </li>




                    <!-- <li class="{{ request()->is('edunika*') ? 'active' : '' }}">
                        <a href="/edunika">
                            <i class="bi bi-bookmark-star"></i>
                            <span>Edunika</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('video_kalkulating') ? 'active' : '' }}">
                        <a href="/video_kalkulating">
                            <i class="bi bi-image"></i>
                            <span>Feeding Screen</span>
                        </a>
                    </li> -->


                </ul>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- All JavaScript Files -->
    <script src="{{ asset('themplete/front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/slideToggle.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/internet-status.js"></script>
    <script src="{{ asset('themplete/front') }}/js/tiny-slider.js"></script>
    <script src="{{ asset('themplete/front') }}/js/venobox.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/countdown.js"></script>
    <script src="{{ asset('themplete/front') }}/js/rangeslider.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/vanilla-dataTables.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/index.js"></script>
    <script src="{{ asset('themplete/front') }}/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/isotope.pkgd.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/dark-rtl.js"></script>
    <script src="{{ asset('themplete/front') }}/js/active.js"></script>
    <script src="{{ asset('themplete/front') }}/js/pwa.js"></script>

    <script>
        $(document).ready(function() {
            var currentUrl = window.location.href;
            $('meta[property="og:url"]').attr('content', currentUrl);
        });
    </script>
</body>

</html>