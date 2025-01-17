@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


@section('content')


    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button -->
                <div class="back-button">
                    <a href="/">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <!-- Page Title -->
                <div class="page-heading">
                    <h6 class="mb-0">{{ $title }} - {{ $profil->nama_perusahaan }}</h6>
                </div>

                <div class="setting-wrapper">
                    <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas"
                        data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="row g-3 justify-content-center">

                @foreach ($galeri as $p)
                    <!-- Single Blog Card -->
                    <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                        <div class="card shadow-sm blog-list-card">
                            <div class="d-flex align-items-center">
                                <div class="card-blog-img position-relative"
                                    style="background-image: url('/upload/galeri/{{ $p->gambar }}')">
                                    
                                </div>
                                <div class="card-blog-content">
                                    
                                    <a class="blog-title d-block mb-3 text-dark"
                                        href="#">{{ $p->nama_galeri }}</a>
                                        <p class="sale-price price-wrapper">
                                            {{ $p->deskripsi }}
                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach





            </div>
        </div>

        <div class="shop-pagination pt-3">
            <div class="container">
                <div class="card">
                    <div class="card-body py-3">
                        {{ $galeri->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

   


@endsection
