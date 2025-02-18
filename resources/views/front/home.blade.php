@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


@section('content')

<!-- Welcome Toast -->
<div class="toast toast-autohide custom-toast-1 toast-success home-page-toast" role="alert" aria-live="assertive"
    aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
    <div class="toast-body">
        <i class="bi bi-bookmark-check text-white h1 mb-0"></i>
        <div class="toast-text ms-3 me-2">
            <p class="mb-1 text-white">Selamat datang di {{ $profil->nama_perusahaan }},</p>
            <small class="d-block">solusi cerdas untuk memantau tumbuh kembang anak secara presisi. Temukan informasi terkini tentang kesehatan anak dan panduan asupan nutrisi di sini!</strong></small>
        </div>
    </div>
    <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
        aria-label="Close"></button>
</div>

<br>
<div class="container">
    <div class="card image-gallery-card direction-rtl">
        <div class="card-body">

            <!-- Tiny Slider One Wrapper -->
            <div class="tiny-slider-one-wrapper">
                <div class="tiny-slider-one">
                    @foreach ($slider as $p)
                    <!-- Single Hero Slide -->
                    <div>
                        <div class="single-hero-slide"
                            style="background-image: url('/upload/slider/{{ $p->gambar }}')">
                            <div class="h-100 d-flex align-items-center text-center">
                                <div class="container">
                                    <h3 class="text-white mb-1">{{ $p->nama_slider }}</h3>
                                    <p class="text-white mb-4">{{ $p->deskripsi }}</p>
                                    <a class="btn btn-creative btn-warning" href="{{ $p->link }}">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>


        </div>
    </div>
</div>



<div class="pt-3"></div>

<div class="container direction-rtl">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                @foreach ($alasan as $p)
                <div class="col-4">
                    <div class="feature-card mx-auto text-center">
                        <div class="card mx-auto bg-gray">
                            <img src="/upload/alasan/{{ $p->gambar }}" alt="">
                        </div>
                        <p class="mb-0">{{ $p->nama_alasan }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
<div class="pb-3"></div>



<div class="container">
    <div class="card card-bg-img bg-img"
        style="background-image: url('/upload/profil/{{ $profil->gambar }}')">
        <div class="card-body direction-rtl p-4">
            <img src="/upload/profil/{{ $profil->logo }}" alt="" width="20%" height="auto">

            <div class="pb-3"></div>
            <h2 class="text-white">{{ $profil->nama_perusahaan }}</h2>
            <p class="mb-4 text-white">{{ $profil->deskripsi }}</p>
            @php
            $no_telp = str_replace(['-', ' ', '+'], '', $profil->no_telp); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
            $pesan =
            'Hallo.. !! Apakah berkenan saya bertanya terkait informasi ' .
            $profil->nama_perusahaan .
            ' ?';
            $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
            $whatsapp_url = "https://wa.me/{$no_telp}?text={$encoded_pesan}"; // Membuat URL lengkap
            @endphp
            <a target="_blank" class="btn btn-warning" href="/hitung_gizi"><i class="bi bi-calculator-fill"></i> Cek Status Gizi</a>
            <a target="_blank" class="btn btn-danger" href="/kpsp"><i class="bi bi-chat-right-quote-fill"></i> Cek Perkembangan Anak</a>

        </div>
    </div>
</div>



<div class="page-content-wrapper" style="margin-top: 25px;">
    <div class="container">
        <div class="row g-3 justify-content-center">

            @foreach ($berita as $p)
            <!-- Single Blog Card -->
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card shadow-sm blog-list-card">
                    <div class="d-flex align-items-center">
                        <div class="card-blog-img position-relative"
                            style="background-image: url('/upload/berita/{{ $p->gambar }}')">
                            <span
                                class="badge bg-warning text-dark position-absolute card-badge">{{ $p->kategoriBerita->nama_kategori_berita }}</span>
                        </div>
                        <div class="card-blog-content">
                            <span
                                class="badge bg-danger rounded-pill mb-2 d-inline-block">{{ $p->tanggal_posting }}</span>
                            <a class="blog-title d-block mb-3 text-dark"
                                href="{{ route('edunika.edunika_detail', $p->slug) }}">{{ $p->judul_berita }}</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('edunika.edunika_detail', $p->slug) }}">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <a class="btn btn-success" href="{{ $whatsapp_url }}"><i class="bi bi-whatsapp"></i> Konsultasi Gratis</a>





        </div>
    </div>


</div>




<div class="container">
    <div class="card image-gallery-card direction-rtl">
        <div class="card-body">

            <div class="embedsocial-hashtag" data-ref="f9b27d015151055ee18fbf13c1cb8fac54649a43"> <a class="feed-powered-by-es feed-powered-by-es-feed-img es-widget-branding" href="https://embedsocial.com/social-media-aggregator/" target="_blank" title="Instagram widget"> <img src="https://embedsocial.com/cdn/icon/embedsocial-logo.webp" alt="EmbedSocial">
                    <div class="es-widget-branding-text">Instagram widget</div>
                </a> </div>
            <script>
                (function(d, s, id) {
                    var js;
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "https://embedsocial.com/cdn/ht.js";
                    d.getElementsByTagName("head")[0].appendChild(js);
                }(document, "script", "EmbedSocialHashtagScript"));
            </script>



        </div>
    </div>
</div>




@endsection