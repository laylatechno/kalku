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

                <!-- Settings -->
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
            <div class="card image-gallery-card direction-rtl">
                <div class="card-body">


                    @foreach ($video as $p)
                        <h5>{{ $p->nama_video }}</h5>
                        <iframe class="mb-3" width="100%" height="315" src="{{ $p->link }}?autoplay=1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allow="autoplay; fullscreen" allowfullscreen></iframe>
                        <hr>
                    @endforeach
















                </div>
            </div>
        </div>


        <div class="pb-3"></div>
        <div class="shop-pagination pt-3">
            <div class="container">
                <div class="card">
                    <div class="card-body py-3">
                        {{ $video->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

  



@endsection
