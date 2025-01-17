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
        <div class="card">
            <div class="card-body unhide">



                <div class="form-group">
                    <h5>
                        Edunika
                    </h5>
                    <p>Edunika merupakan informasi terkait secara umum</p>
                    <a href="/edunika">
                        <button type="submit"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            Masuk Edunika

                        </button>
                    </a>


                </div>


                <div class="form-group">
                    <h5>
                        Feeding Screen
                    </h5>
                    <p>Feeding Screen merupakan informasi terkait secara umum</p>
                    <a href="/video_kalkulating">
                        <button type="submit"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            Masuk Feeding Screen

                        </button>
                    </a>

                </div>








            </div>







        </div>
    </div>
</div>




@endsection