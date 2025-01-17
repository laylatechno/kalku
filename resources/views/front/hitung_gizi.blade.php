@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


@section('content')


<!-- Header Area -->
<div class="header-area unhide" id="headerArea">
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
    <!-- Element Heading -->
    <div class="container">
        <div class="element-heading unhide">
            <h6>Form Kalkulator Gizi</h6>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body unhide">
                @isset($errorMessage)
                <div class="alert alert-danger" role="alert">
                    {{ $errorMessage }}
                </div>
                <a href="/hitung_gizi">
                    <button type="button"
                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                        Kembali Hitung
                        <i class="bi bi-calculator fz-16 ms-1"></i>
                    </button>
                </a>
                @else
                <form action="{{ route('proses_gizi.determine') }}" method="POST" class="was-validated" novalidate>
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="jenis_kelamin">
                            Pilih Jenis Kelamin
                            <span class="text-danger">*</span>
                        </label>
                        <label class="single-plan-check shadow-sm active-effect">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="male"
                                    value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}
                                    required>
                                <span class="form-check-label">Laki-laki</span>
                            </div>
                            <i class="bi bi-gender-male fz-20 ms-auto"></i>
                        </label>

                        <label class="single-plan-check shadow-sm active-effect">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="female"
                                    value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <span class="form-check-label">Perempuan</span>
                            </div>
                            <i class="bi bi-gender-female fz-20 ms-auto"></i>
                        </label>
                        @if ($errors->has('jenis_kelamin'))
                        <span class="text-danger d-block mt-1">{{ $errors->first('jenis_kelamin') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nama">
                            Nama
                        </label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="nama" name="nama" type="text"
                                placeholder="Masukkan Nama" value="{{ old('nama') }}">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger d-block">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_lahir">
                            Tanggal Lahir
                            <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" id="tanggal_lahir" name="tanggal_lahir" type="date"
                            value="{{ old('tanggal_lahir') }}" required>
                        @if ($errors->has('tanggal_lahir'))
                        <span class="text-danger d-block">{{ $errors->first('tanggal_lahir') }}</span>
                        @endif
                    </div>
                    <script>
                        document.getElementById('tanggal_lahir').addEventListener('change', function() {
                            const tanggalLahir = new Date(this.value);
                            const today = new Date();

                            let umurBulan = (today.getFullYear() - tanggalLahir.getFullYear()) * 12;
                            umurBulan -= tanggalLahir.getMonth();
                            umurBulan += today.getMonth();

                            if (today.getDate() < tanggalLahir.getDate()) {
                                umurBulan--;
                            }

                            document.getElementById('umur').value = umurBulan;
                        });

                        // Script untuk mengatur nilai default pada radio button jenis kelamin
                        document.addEventListener('DOMContentLoaded', function() {
                            const radioButtons = document.querySelectorAll('input[name="jenis_kelamin"]');
                            const hiddenInput = document.getElementById('jenis_kelamin');

                            radioButtons.forEach(radio => {
                                radio.addEventListener('change', function() {
                                    hiddenInput.value = this.value;
                                });
                            });

                            const checkedRadio = document.querySelector('input[name="jenis_kelamin"]:checked');
                            if (checkedRadio) {
                                hiddenInput.value = checkedRadio.value;
                            }
                        });
                    </script>

                    <div class="form-group">
                        <label class="form-label" for="umur">
                            Usia
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="umur" name="umur" type="text"
                                placeholder="Usia terisi otomatis setelah input tanggal lahir namun bisa langsung isi"
                                value="{{ old('umur') }}">
                            <span class="input-group-text">bulan</span>
                        </div>
                        @if ($errors->has('umur'))
                        <span class="text-danger d-block">{{ $errors->first('umur') }}</span>
                        @endif
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="tinggi_badan">
                            Tinggi Badan
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <select class="form-select" id="tinggi_badan" name="tinggi_badan" required>
                                <option value="">Pilih tinggi badan</option>
                                @php
                                // Generate options from 45.0 to 110.0 with 0.5 increments
                                $tinggi_badan_options = range(45.0, 110.0, 0.5);
                                @endphp
                                @foreach ($tinggi_badan_options as $tinggi_badan_option)
                                <option value="{{ number_format($tinggi_badan_option, 1) }}"
                                    {{ old('tinggi_badan') == $tinggi_badan_option ? 'selected' : '' }}>
                                    {{ number_format($tinggi_badan_option, 1) }} cm
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('tinggi_badan'))
                        <span class="text-danger d-block">{{ $errors->first('tinggi_badan') }}</span>
                        @endif
                    </div>



                    <div class="form-group">
                        <label class="form-label" for="berat_badan">
                            Berat Badan
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">

                            <input class="form-control" id="berat_badan" name="berat_badan" type="number"
                                step="0.1" placeholder="Masukkan berat badan" value="{{ old('berat_badan') }}"
                                required>
                            <span class="input-group-text">Kg</span>
                        </div>
                        @if ($errors->has('berat_badan'))
                        <span class="text-danger d-block">{{ $errors->first('berat_badan') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nama_ortu">Nama Orang Tua <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="nama_ortu" name="nama_ortu" type="text"
                                placeholder="Masukkan Nama Orang Tua" value="{{ old('nama_ortu') }}">
                        </div>
                        @if ($errors->has('nama_ortu'))
                        <span class="text-danger d-block">{{ $errors->first('nama_ortu') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="no_wa">Nomor WA <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="no_wa" name="no_wa" type="number"
                                placeholder="Masukkan Nomor WA" value="{{ old('no_wa') }}">
                        </div>
                        @if ($errors->has('no_wa'))
                        <span class="text-danger d-block">{{ $errors->first('no_wa') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="wilayah_kerja_puskesmas">
                            Wilayah Kerja Puskesmas <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="wilayah_kerja_puskesmas" name="wilayah_kerja_puskesmas" type="text"
                                placeholder="Masukkan wilayah kerja puskesmas" value="{{ old('wilayah_kerja_puskesmas') }}">
                        </div>
                        @if ($errors->has('wilayah_kerja_puskesmas'))
                        <span class="text-danger d-block">{{ $errors->first('wilayah_kerja_puskesmas') }}</span>
                        @endif
                    </div>

                    <span style="font-size: 0.775em; color: rgb(209, 46, 46); font-style: italic;">* Inputan Wajib
                        Diisi</span>

                    <br>

                    <button type="submit"
                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center"><i
                            class="bi bi-calculator fz-16 ms-1"></i>
                        Hitung

                    </button>
                </form>



                @endisset
            </div>

            @if (session()->has('nama') &&
            session()->has('umur') &&
            session()->has('nama_ortu') &&
            session()->has('no_wa') &&
            session()->has('wilayah_kerja_puskesmas') &&
            session()->has('berat_badan') &&
            session()->has('tinggi_badan') &&
            session()->has('heightStatus') &&
            session()->has('bbptuStatus') &&
            session()->has('imtStatus') &&
            session()->has('weightStatus'))

            <div class="card" id="hasil_hitung">
                <div class="card-body">
                    <h5 class="card-title">Laporan Hasil Hitung Gizi {{ $profil->nama_perusahaan }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-person-bounding-box"></i> Nama:
                                    {{ session('nama') }}
                                </li>
                                <li class="list-group-item"><i class="bi bi-gender-male"></i> Jenis Kelamin:
                                    {{ session('jenis_kelamin') }}
                                </li>
                                <li class="list-group-item"><i class="bi bi-box"></i> Umur: {{ session('umur') }}
                                    bulan</li>
                                <li class="list-group-item"><i class="bi bi-kanban"></i> Tinggi Badan:
                                    {{ session('tinggi_badan') }} cm
                                </li>
                                <li class="list-group-item"><i class="bi bi-postage"></i> Berat Badan:
                                    {{ session('berat_badan') }} kg
                                </li>
                                <li class="list-group-item"><i class="bi bi-people"></i> Nama Ortu:
                                    {{ session('nama_ortu') }}
                                </li>
                                <li class="list-group-item"><i class="bi bi-whatsapp"></i> No WA:
                                    {{ session('no_wa') }}
                                </li>
                                <li class="list-group-item"><i class="bi bi-bank"></i> Wilayah Kerja Puskesmas:
                                    {{ session('wilayah_kerja_puskesmas') }}
                                </li>
                                <br>
                                <hr>
                            </ul>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <h5 class="card-title">Berat Badan menurut Umur (BB/U) </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-chat-dots"></i> Status :
                                    <strong>{{ session('weightStatus') }}</strong>
                                </li>
                            </ul>
                            <h5 class="card-title">Panjang Badan menurut Umur (PB/U) atau (TB/U) </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-chat-dots"></i> Status :
                                    <strong>{{ session('heightStatus') }}</strong>
                                </li>
                            </ul>
                            <h5 class="card-title">Berat Badan menurut Panjang Badan (BB/PB) atau (BB/TB) </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-chat-dots"></i> Status :
                                    <strong>{{ session('bbptuStatus') }}</strong>
                                </li>
                            </ul>
                            <h5 class="card-title">Indeks Massa Tubuh menurut Umur (IMT/U) </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-chat-dots"></i> Status :
                                    <strong>{{ session('imtStatus') }}</strong>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <p><b>DISCLAIMER : </b>Perlu diingat, ini bukan hasil pemeriksaan medis. Kami sarankan untuk
                            berkonsultasi dengan petugas kesehatan untuk informasi lebih lanjut.</p>
                    </div>
                    <button id="captureBtn" class="btn btn-primary mt-3 unhide"><i class="bi bi-bookmark"></i>
                        Simpan Hasil Hitung Gizi</button>
                </div>
            </div>



            <script>
                document.getElementById('captureBtn').addEventListener('click', function(event) {
                    event.preventDefault();
                    alert('Untuk menyimpan laporan sebagai PDF, pilih "Save as PDF" pada opsi printer.');
                    window.print();
                });
            </script>
            @endif





        </div>
    </div>


</div>



<script>
    // Scroll to element with id="hasil_hitung"
    window.onload = function() {
        const hasilHitungElement = document.getElementById('hasil_hitung');
        if (hasilHitungElement) {
            hasilHitungElement.scrollIntoView({
                behavior: 'smooth'
            });
        }
    };
</script>



@endsection