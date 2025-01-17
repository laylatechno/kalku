@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
<!-- <style>
    /* Gaya untuk mengatur tampilan cetak */
    @media print {

        /* Sembunyikan elemen yang tidak ingin dicetak */
        .btn,
        .card-header {
            display: none !important;
        }

        /* Pastikan tampilan rapi */
        body {
            margin: 0;
            padding: 10px;
            font-size: 12px;
        }

        .container {
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    }
</style> -->


<!-- <style>
    .card {
        border-radius: 10px;
        padding: 10px;
        margin-top: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .card h5 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .card p,
    .card ol {
        font-size: 1rem;
    }
</style> -->




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



<div class="page-content-wrapper unhide" style="padding-top: 15px;">
    <div class="container">
        <!-- Accordion Card -->
        <div class="card bg-primary rounded-0 rounded-top">
            <div class="card-body text-center py-3">
                <h6 class="mb-0 text-white line-height-1">Lengkapi Terlebih Dahulu Data Diri Anda</h6>
            </div>
        </div>



        <div class="card">
            <div class="card-body">
                <div class="contact-form">
                    <!-- Tampilkan pesan sukses jika ada -->
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Tampilkan error validasi -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('home.hasil_sras') }}" method="POST" class="was-validated" novalidate>
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama <span class="text-danger">*</span></label>
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
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" id="tanggal_lahir" name="tanggal_lahir" type="date"
                                value="{{ old('tanggal_lahir') }}" required oninput="calculateAge()">
                            @if ($errors->has('tanggal_lahir'))
                            <span class="text-danger d-block">{{ $errors->first('tanggal_lahir') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="umur">Umur (Tahun)</label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="umur" name="umur" type="number"
                                    placeholder="Umur dihitung Otomatis" value="{{ old('umur') }}">
                            </div>
                            @if ($errors->has('umur'))
                            <span class="text-danger d-block">{{ $errors->first('umur') }}</span>
                            @endif
                        </div>
                        <script>
                            function calculateAge() {
                                const inputDate = document.getElementById('tanggal_lahir').value;
                                const umurInput = document.getElementById('umur');

                                if (inputDate) {
                                    const today = new Date();
                                    const birthDate = new Date(inputDate);
                                    let age = today.getFullYear() - birthDate.getFullYear();
                                    const monthDiff = today.getMonth() - birthDate.getMonth();

                                    // Jika bulan hari ini lebih kecil dari bulan lahir, atau bulan sama tapi tanggal lebih kecil, kurangi umur.
                                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                                        age--;
                                    }

                                    umurInput.value = age; // Set hasil umur ke input umur
                                } else {
                                    umurInput.value = ''; // Kosongkan jika input tanggal dihapus
                                }
                            }
                        </script>

                        <div class="form-group">
                            <label class="form-label" for="jenis_kelamin">
                                Pilih Jenis Kelamin <span class="text-danger">*</span>
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
                            <label class="form-label" for="tinggi_badan">
                                Tinggi Badan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="tinggi_badan" name="tinggi_badan" type="number"
                                    step="0.1" placeholder="Masukkan tinggi badan dalam cm" value="{{ old('tinggi_badan') }}" required>
                                <span class="input-group-text">Cm</span>
                            </div>
                            @if ($errors->has('tinggi_badan'))
                            <span class="text-danger d-block">{{ $errors->first('tinggi_badan') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="berat_badan">
                                Berat Badan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="berat_badan" name="berat_badan" type="number"
                                    step="0.1" placeholder="Masukkan berat badan dalam kg" value="{{ old('berat_badan') }}" required>
                                <span class="input-group-text">Kg</span>
                            </div>
                            @if ($errors->has('berat_badan'))
                            <span class="text-danger d-block">{{ $errors->first('berat_badan') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="imt">
                                Indeks Massa Tubuh (IMT)
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="imt" name="imt" type="text" placeholder="IMT dihitung otomatis" readonly>
                                <span class="input-group-text">Kg/m²</span>
                            </div>
                        </div>

                        <script>
                            // Fungsi untuk menghitung IMT dan mengupdate radio button berdasarkan rentang IMT
                            function calculateIMT() {
                                const tinggiCm = parseFloat(document.getElementById('tinggi_badan').value); // Tinggi dalam cm
                                const berat = parseFloat(document.getElementById('berat_badan').value); // Berat dalam kg
                                const imtInput = document.getElementById('imt');

                                if (tinggiCm > 0 && berat > 0) {
                                    const tinggiM = tinggiCm / 100; // Konversi tinggi ke meter
                                    const imt = (berat / (tinggiM * tinggiM)).toFixed(2); // Hitung IMT
                                    imtInput.value = imt;

                                    // Tentukan rentang dan centang radio button yang sesuai
                                    document.querySelectorAll('.imt-radio').forEach(radio => {
                                        radio.checked = false; // Reset radio button
                                    });

                                    if (imt < 17) {
                                        document.getElementById('imt_low').checked = true;
                                    } else if (imt >= 17 && imt < 18.5) {
                                        document.getElementById('imt_mild').checked = true;
                                    } else if (imt >= 18.5 && imt <= 25) {
                                        document.getElementById('imt_normal').checked = true;
                                    } else if (imt > 25 && imt <= 27) {
                                        document.getElementById('imt_overweight').checked = true;
                                    } else if (imt > 27) {
                                        document.getElementById('imt_obese').checked = true;
                                    }
                                } else {
                                    imtInput.value = ''; // Kosongkan jika input tidak valid
                                }
                            }

                            // Event listener untuk input tinggi dan berat badan
                            document.getElementById('tinggi_badan').addEventListener('input', calculateIMT);
                            document.getElementById('berat_badan').addEventListener('input', calculateIMT);
                        </script>

                        <div class="form-group">
                            <label class="form-label" for="lila">
                                Ukuran LILA <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="lila" name="lila" type="text"
                                    placeholder="Masukkan Lingkar Lengan Atas" value="{{ old('lila') }}">
                            </div>
                            @if ($errors->has('lila'))
                            <span class="text-danger d-block">{{ $errors->first('lila') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="hb">
                                Pemeriksaan HB <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="hb" name="hb" type="number"
                                    placeholder="Masukkan Pemeriksaan HB" value="{{ old('hb') }}">
                            </div>
                            @if ($errors->has('hb'))
                            <span class="text-danger d-block">{{ $errors->first('hb') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="sekolah">
                                Sekolah
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="sekolah" name="sekolah" type="text"
                                    placeholder="Masukkan sekolah" value="{{ old('sekolah') }}">
                            </div>
                            @if ($errors->has('sekolah'))
                            <span class="text-danger d-block">{{ $errors->first('sekolah') }}</span>
                            @endif
                        </div>

                        <span style="font-size: 0.775em; color: rgb(209, 46, 46); font-style: italic;">* Inputan Wajib
                            Diisi</span><br>
                        <span style="font-size: 0.775em; color: rgb(209, 46, 46); font-style: italic;">* Deteksi risiko stunting hanya untuk remaja putri</span>


                </div>
            </div>
        </div>
    </div>


    <!-- <div class="container" id="kuesioner-container" style="display: none;"> -->
    <div class="container" id="kuesioner-container" style="margin-top: 15px;">
        <!-- Header Card -->
        <div id="kuesioner-content">
            <!-- Checkout Wrapper -->
            <div class="checkout-wrapper-area">
                <div class="card">
                    <div class="card-body checkout-form">
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const lilaInput = document.getElementById('lila'); // Input LILA
                                const umurInput = document.getElementById('umur'); // Input Umur

                                // Semua radio button LILA
                                const radioGroups = [{
                                        radios: [
                                            document.getElementById('lila_radio_1'), // > 18.5 cm
                                            document.getElementById('lila_radio_2'), // 16.0 cm - <= 18.5 cm
                                            document.getElementById('lila_radio_3') // < 16.0 cm
                                        ],
                                        ageRange: [10, 14], // Umur 10-14 tahun
                                        conditions: [
                                            (lila) => lila > 18.5,
                                            (lila) => lila >= 16 && lila <= 18.5,
                                            (lila) => lila < 16
                                        ]
                                    },
                                    {
                                        radios: [
                                            document.getElementById('lila_radio_4'), // > 22.0 cm
                                            document.getElementById('lila_radio_5'), // 18.5 cm - <= 22.0 cm
                                            document.getElementById('lila_radio_6') // < 18.5 cm
                                        ],
                                        ageRange: [15, 17], // Umur 15-17 tahun
                                        conditions: [
                                            (lila) => lila > 22.0,
                                            (lila) => lila >= 18.5 && lila <= 22.0,
                                            (lila) => lila < 18.5
                                        ]
                                    },
                                    {
                                        radios: [
                                            document.getElementById('lila_radio_7'), // < 23.5 cm
                                            document.getElementById('lila_radio_8') // > 23.5 cm
                                        ],
                                        ageRange: [18, Infinity], // Umur > 18 tahun
                                        conditions: [
                                            (lila) => lila < 23.5,
                                            (lila) => lila > 23.5
                                        ]
                                    }
                                ];

                                function updateRadioButtons() {
                                    const umur = parseInt(umurInput.value) || 0;
                                    const lila = parseFloat(lilaInput.value) || 0;

                                    radioGroups.forEach(group => {
                                        const [minAge, maxAge] = group.ageRange;

                                        if (umur >= minAge && umur <= maxAge) {
                                            group.radios.forEach((radio, index) => {
                                                if (group.conditions[index](lila)) {
                                                    radio.checked = true;
                                                } else {
                                                    radio.checked = false;
                                                }
                                            });
                                        } else {
                                            // Reset all radios in this group if umur doesn't match the range
                                            group.radios.forEach(radio => {
                                                radio.checked = false;
                                            });
                                        }
                                    });
                                }

                                // Event listeners untuk input perubahan
                                lilaInput.addEventListener('input', updateRadioButtons);
                                umurInput.addEventListener('input', updateRadioButtons);
                            });
                        </script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const umurInput = document.getElementById('umur');
                                const hbInput = document.getElementById('hb');

                                const hbGroups = [{
                                        ageRange: [10, 11],
                                        radios: [{
                                                id: 'hb_radio_1',
                                                condition: (hb) => hb >= 11.0
                                            },
                                            {
                                                id: 'hb_radio_2',
                                                condition: (hb) => hb >= 11.0 && hb <= 11.4
                                            },
                                            {
                                                id: 'hb_radio_3',
                                                condition: (hb) => hb >= 8.0 && hb <= 10.9
                                            },
                                            {
                                                id: 'hb_radio_4',
                                                condition: (hb) => hb < 8.0
                                            },
                                        ],
                                    },
                                    {
                                        ageRange: [12, 14],
                                        radios: [{
                                                id: 'hb_radio_5',
                                                condition: (hb) => hb >= 12.0
                                            },
                                            {
                                                id: 'hb_radio_6',
                                                condition: (hb) => hb >= 11.0 && hb <= 11.9
                                            },
                                            {
                                                id: 'hb_radio_7',
                                                condition: (hb) => hb >= 8.0 && hb <= 10.9
                                            },
                                            {
                                                id: 'hb_radio_8',
                                                condition: (hb) => hb < 8.0
                                            },
                                        ],
                                    },
                                    {
                                        ageRange: [15, Infinity],
                                        radios: [{
                                                id: 'hb_radio_9',
                                                condition: (hb) => hb >= 12.0
                                            },
                                            {
                                                id: 'hb_radio_10',
                                                condition: (hb) => hb >= 11.0 && hb <= 11.9
                                            },
                                            {
                                                id: 'hb_radio_11',
                                                condition: (hb) => hb >= 8.0 && hb <= 10.9
                                            },
                                            {
                                                id: 'hb_radio_12',
                                                condition: (hb) => hb < 8.0
                                            },
                                        ],
                                    },
                                ];

                                function updateHbRadios() {
                                    const umur = parseInt(umurInput.value) || 0;
                                    const hb = parseFloat(hbInput.value) || 0;

                                    hbGroups.forEach((group) => {
                                        const [minAge, maxAge] = group.ageRange;
                                        if (umur >= minAge && umur <= maxAge) {
                                            group.radios.forEach(({
                                                id,
                                                condition
                                            }) => {
                                                const radio = document.getElementById(id);
                                                radio.checked = condition(hb);
                                            });
                                        } else {
                                            group.radios.forEach(({
                                                id
                                            }) => {
                                                document.getElementById(id).checked = false;
                                            });
                                        }
                                    });
                                }

                                hbInput.addEventListener('input', updateHbRadios);
                                umurInput.addEventListener('input', updateHbRadios);
                            });
                        </script>
                        <script>
                            document.getElementById('imt').addEventListener('change', function() {
                                // Ambil nilai IMT dari input
                                const imtValue = parseFloat(this.value);

                                // Reset semua radio button
                                document.querySelectorAll('.imt-radio').forEach(radio => {
                                    radio.checked = false;
                                });

                                // Tentukan rentang dan centang radio button yang sesuai
                                if (imtValue < 17) {
                                    document.getElementById('imt_low').checked = true;
                                } else if (imtValue >= 17 && imtValue < 18.5) {
                                    document.getElementById('imt_mild').checked = true;
                                } else if (imtValue >= 18.5 && imtValue <= 25) {
                                    document.getElementById('imt_normal').checked = true;
                                } else if (imtValue > 25 && imtValue <= 27) {
                                    document.getElementById('imt_overweight').checked = true;
                                } else if (imtValue > 27) {
                                    document.getElementById('imt_obese').checked = true;
                                }
                            });
                        </script>

                        <div hidden>
                            <h6 class="mb-3">A. Lingkar Lengan Atas (LILA)</h6>

                            <!-- 1. Remaja 10-14 Tahun -->
                            <p><strong>1. Remaja 10-14 tahun</strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_1" value="0"
                                    {{ (old('umur') >= 10 && old('umur') <= 14 && old('lila') > 18.5) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_1">> 18.5 cm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_2" value="1"
                                    {{ (old('umur') >= 10 && old('umur') <= 14 && old('lila') >= 16 && old('lila') <= 18.5) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_2">16.0 cm - <= 18.5 cm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_3" value="2"
                                    {{ (old('umur') >= 10 && old('umur') <= 14 && old('lila') < 16) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_3">
                                    < 16.0 cm</label>
                            </div>
                            <hr>

                            <!-- 2. Remaja 15-17 Tahun -->
                            <p><strong>2. Remaja 15-17 tahun</strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_4" value="0"
                                    {{ (old('umur') >= 15 && old('umur') <= 17 && old('lila') > 22.0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_4">> 22.0 cm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_5" value="1"
                                    {{ (old('umur') >= 15 && old('umur') <= 17 && old('lila') >= 18.5 && old('lila') <= 22.0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_5">18.5 cm - <= 22.0 cm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_6" value="2"
                                    {{ (old('umur') >= 15 && old('umur') <= 17 && old('lila') < 18.5) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_6">
                                    < 18.5 cm</label>
                            </div>
                            <hr>

                            <!-- 3. Remaja > 18 Tahun -->
                            <p><strong>3. Remaja > 18 tahun</strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_7" value="0"
                                    {{ (old('umur') > 18 && old('lila') < 23.5) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_7">
                                    < 23.5 cm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="lila_radio" id="lila_radio_8" value="1"
                                    {{ (old('umur') > 18 && old('lila') > 23.5) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lila_radio_8">> 23.5 cm</label>
                            </div>
                            <hr>


                        </div>
                        <div hidden>

                            <h6 class="mb-3">B. Kadar Hemoglobin (Hb)</h6>

                            <p><strong>1. Usia 10-11 Tahun </strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_1" value="0">
                                <label class="form-check-label" for="hb_radio_1">
                                    > 11,5 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_2" value="1">
                                <label class="form-check-label" for="hb_radio_2">11,0-11,4 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_3" value="2">
                                <label class="form-check-label" for="hb_radio_3">8,0-10,9 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_4" value="3">
                                <label class="form-check-label" for="hb_radio_4">
                                    < 8,0 gr/dl</label>
                            </div>
                            <hr>

                            <p><strong>2. Usia 12-14 Tahun </strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_5" value="0">
                                <label class="form-check-label" for="hb_radio_5">
                                    > 12 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_6" value="1">
                                <label class="form-check-label" for="hb_radio_6">11,0-11,9 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_7" value="2">
                                <label class="form-check-label" for="hb_radio_7">8,0-10,9 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_8" value="3">
                                <label class="form-check-label" for="hb_radio_8">
                                    < 8,0 gr/dl</label>
                            </div>
                            <hr>

                            <p><strong>3. Usia > 15 Tahun </strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_9" value="0">
                                <label class="form-check-label" for="hb_radio_9">
                                    > 12 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_10" value="1">
                                <label class="form-check-label" for="hb_radio_10">11,0-11,9 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_11" value="2">
                                <label class="form-check-label" for="hb_radio_11">8,0-10,9 gr/dl</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hb_group" id="hb_radio_12" value="3">
                                <label class="form-check-label" for="hb_radio_12">
                                    < 8,0 gr/dl</label>
                            </div>
                            <hr>



                        </div>
                        <div hidden>
                            <h6 class="mb-3">C. Status Gizi</h6>
                            <p><strong>Indeks Massa Tubuh (IMT)</strong></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input imt-radio" type="radio" name="imt_category" id="imt_low" value="2">
                                <label class="" for="imt_low">
                                    < 17,0</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input imt-radio" type="radio" name="imt_category" id="imt_mild" value="1">
                                <label class="" for="imt_mild">17-18,5</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input imt-radio" type="radio" name="imt_category" id="imt_normal" value="0">
                                <label class="" for="imt_normal">18,5-25,0</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input imt-radio" type="radio" name="imt_category" id="imt_overweight" value="1">
                                <label class="" for="imt_overweight">25,0-27,0</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input imt-radio" type="radio" name="imt_category" id="imt_obese" value="1">
                                <label class="" for="imt_obese">> 27,0</label>
                            </div>

                            <hr>
                        </div>

                        <h6 class="mb-3">A. Asupan Nutrisi</h6>
                        <p><strong>1. Konsumsi Asupan Protein 50 gram/hari
                                (Terdapat dalam telur, daging ayam, ikan, daging sapi/kambing, tempe, tahu)
                            </strong></p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="asupan_nutrisi" id="ya_d_1" value="0">
                            <label class="" for="ya_d_1">Ya</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="asupan_nutrisi" id="tidak_d_1" value="1">
                            <label class="" for="tidak_d_1">Tidak</label>
                        </div>
                        <hr>

                        <p><strong>2. Konsumsi Asupan Zink 8 mg/hari
                                (Terdapat dalam telur, ikan, daging sapi/ kambing, kacang-kacangan)
                            </strong></p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="asupan_zink" id="ya_d_2" value="0">
                            <label class="" for="ya_d_2">Ya</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="asupan_zink" id="tidak_d_2" value="1">
                            <label class="" for="tidak_d_2">Tidak</label>
                        </div>
                        <hr>

                        <h6 class="mb-3">B. Konsumsi Tablet Tambah Darah </h6>
                        <p><strong>Apakah mengkonsumsi tablet tambah? </strong></p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="konsumsi_tablet" id="tidak_konsumsi_e_1" value="2">
                            <label class="" for="tidak_konsumsi_e_1">Tidak mengkonsumsi </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="konsumsi_tablet" id="konsumsi_e_1" value="0">
                            <label class="" for="konsumsi_e_1">Konsumsi Minimal Sekali dalam Seminggu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="konsumsi_tablet" id="konsumsi_haid_e_1" value="0">
                            <label class="" for="konsumsi_haid_e_1">Konsumsi Minimal Sekali dalam Seminggu dilanjut setiap hari ketika haid</label>
                        </div>
                        <hr>

                        <h6 class="mb-3">C. Kondisi Lingkungan </h6>
                        <p><strong>Apakah tersedia akses air bersih & sanitasi? </strong></p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="kondisi_lingkungan" id="tidak_f_1" value="2">
                            <label class=" " for="tidak_f_1">Tidak ada </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="kondisi_lingkungan" id="ya_f_1" value="0">
                            <label class="" for="ya_f_1">Tersedia</label>
                        </div>
                        <hr>

                        <h6 class="mb-3">D. Tingkat Stres</h6>
                        <p><strong>Pilih Sesuai Kondisi</strong></p>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="cemas_g_1" id="cemas_g_1" value="1">
                            <label class="" for="cemas_g_1">Mengalami kecemasan berlebih ≥5 hari kebelakang</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="tidur_g_1" id="tidur_g_1" value="1">
                            <label class="" for="tidur_g_1">Mengalami sulit tidur ≥5 hari kebelakang</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="konsentrasi_g_1" id="konsentrasi_g_1" value="1">
                            <label class="" for="konsentrasi_g_1">Mengalami sulit berkonsentrasi ≥5 hari kebelakang</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="tidak_g_1" id="tidak_g_1" value="0">
                            <label class="" for="tidak_g_1">Tidak mengalami gangguan kecemasan berlebih, sulit tidur, sulit berkonsentrasi</label>
                        </div>
                        <hr>

                        <h6 class="mb-3">E. Riwayat Kesehatan </h6>
                        <p><strong>Apakah terdapat riwayat penyakit kronis? (TBC, Infeksi cacing, dll) </strong></p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="riwayat_kesehatan" id="riwayat_kesehatan_ya" value="2">
                            <label class=" " for="riwayat_kesehatan_ya">Ya </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="riwayat_kesehatan" id="riwayat_kesehatan_tidak" value="0">
                            <label class="" for="riwayat_kesehatan_tidak">Tidak </label>
                        </div>
                        <hr>

                        <div class="row" hidden>
                            <div class="col-md-6">
                                <!-- Summary Section -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Summary Value 1</label>
                                    <input type="number" name="summary_1" id="summary_1" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Summary Value 2</label>
                                    <input type="number" name="summary_2" id="summary_2" class="form-control">
                                </div>

                                <!-- Total Summary -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Total Summary</label>
                                    <input type="number" name="total_summary" id="total_summary" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Count Section -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Count Value 0</label>
                                    <input type="text" name="count_0" id="count_0" class="form-control" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Count Value 1</label>
                                    <input type="text" name="count_1" id="count_1" class="form-control" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Count Value 2</label>
                                    <input type="text" name="count_2" id="count_2" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Card Section for Risk Information -->
                        <div id="stuntingCard" class="card" hidden>
                            <div class="card-body" id="stuntingMessage">
                                <!-- Content will be updated dynamically -->
                            </div>
                        </div>

                        <input type="hidden" name="total_summary" id="total_summary_input">
                        <input type="hidden" name="hasil" id="hasil_input">
                        <input type="hidden" name="deskripsi" id="deskripsi_input">


                        <button type="submit" class="btn btn-success mt-3 w-100" hidden><i class="bi bi-cloud-arrow-down"></i> Simpan</button>
                        </form>
                        <button class="btn btn-primary mt-3 w-100"><i class="bi bi-calculator"></i> Cek Sekarang</button>
                    </div>
                </div>
            </div>

        </div>



    </div>



</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for "Cek Sekarang" button
        const cekButton = document.querySelector('.btn-primary');
        const simpanButton = document.querySelector('.btn-success');
        const stuntingCard = document.getElementById('stuntingCard');
        const formElement = document.getElementById('stuntingForm'); // Make sure your form has this ID

        if (cekButton) {
            cekButton.addEventListener('click', function() {
                // Calculate values first
                hitungNilai();

                // Show the save button and stunting card
                if (simpanButton) simpanButton.hidden = false;
                if (stuntingCard) stuntingCard.hidden = false;
            });
        }

        // Checkbox logic for "tidak" option
        const tidakCheckbox = document.getElementById('tidak_g_1');
        const cemasCheckbox = document.getElementById('cemas_g_1');
        const tidurCheckbox = document.getElementById('tidur_g_1');
        const konsentrasiCheckbox = document.getElementById('konsentrasi_g_1');

        function toggleOtherCheckboxes() {
            if (!tidakCheckbox) return;

            const isChecked = tidakCheckbox.checked;

            if (isChecked) {
                if (cemasCheckbox) {
                    cemasCheckbox.checked = false;
                    cemasCheckbox.disabled = true;
                }
                if (tidurCheckbox) {
                    tidurCheckbox.checked = false;
                    tidurCheckbox.disabled = true;
                }
                if (konsentrasiCheckbox) {
                    konsentrasiCheckbox.checked = false;
                    konsentrasiCheckbox.disabled = true;
                }
            } else {
                if (cemasCheckbox) cemasCheckbox.disabled = false;
                if (tidurCheckbox) tidurCheckbox.disabled = false;
                if (konsentrasiCheckbox) konsentrasiCheckbox.disabled = false;
            }
        }

        if (tidakCheckbox) {
            tidakCheckbox.addEventListener('change', toggleOtherCheckboxes);
            toggleOtherCheckboxes(); // Initial state
        }

        function getLILACriteria(selectedRadio) {
            const criteriaMap = {
                'lila_radio_1': 'Normal', // >18.5 cm (10-14 tahun)
                'lila_radio_2': 'Sedang', // 16.0-18.5 cm (10-14 tahun)
                'lila_radio_3': 'Berat', // <16.0 cm (10-14 tahun)
                'lila_radio_4': 'Normal', // >22.0 cm (15-17 tahun)
                'lila_radio_5': 'Sedang', // 18.5-22.0 cm (15-17 tahun)
                'lila_radio_6': 'Berat', // <18.5 cm (15-17 tahun)
                'lila_radio_7': 'Normal', // <23.5 cm (>18 tahun)
                'lila_radio_8': 'Berat' // >23.5 cm (>18 tahun)
            };
            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        function getHbCriteria(selectedRadio) {
            const criteriaMap = {
                'hb_radio_1': 'Normal', // <11.5 gr/dl (10-11 tahun)
                'hb_radio_2': 'Anemia Ringan', // 11.0-11.4 gr/dl (10-11 tahun)
                'hb_radio_3': 'Anemia Sedang', // 8.0-10.9 gr/dl (10-11 tahun)
                'hb_radio_4': 'Anemia Berat', // <8.0 gr/dl (10-11 tahun)
                'hb_radio_5': 'Normal', // <12 gr/dl (12-24 tahun)
                'hb_radio_6': 'Anemia Ringan', // 11.0-11.9 gr/dl (12-24 tahun)
                'hb_radio_7': 'Anemia Sedang', // 8.0-10.9 gr/dl (12-24 tahun)
                'hb_radio_8': 'Anemia Berat', // <8.0 gr/dl (12-24 tahun)
                'hb_radio_9': 'Normal', // <12 gr/dl (>15 tahun)
                'hb_radio_10': 'Anemia Ringan', // 11.0-11.9 gr/dl (>15 tahun)
                'hb_radio_11': 'Anemia Sedang', // 8.0-10.9 gr/dl (>15 tahun)
                'hb_radio_12': 'Anemia Berat' // <8.0 gr/dl (>15 tahun)
            };
            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        function getIMTCriteria(selectedRadio) {
            const criteriaMap = {
                'imt_low': 'Sangat Kurus', // < 17.0
                'imt_mild': 'Kurus', // 17-18.5
                'imt_normal': 'Normal', // 18.5-25.0
                'imt_overweight': 'Gemuk', // 25.0-27.0
                'imt_obese': 'Obesitas' // > 27.0
            };
            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        function hitungNilai() {
            let counts = {
                value0: 0,
                value1: 0,
                value2: 0
            };

            let totals = {
                value1: 0,
                value2: 0
            };

            const checkedInputs = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');

            checkedInputs.forEach(input => {
                const value = parseInt(input.value);
                if (value === 0) {
                    counts.value0++;
                } else if (value === 1) {
                    counts.value1++;
                    totals.value1 += 1;
                } else if (value === 2) {
                    counts.value2++;
                    totals.value2 += 2;
                }
            });

            const countElements = {
                count_0: counts.value0,
                count_1: counts.value1,
                count_2: counts.value2,
                summary_1: totals.value1,
                summary_2: totals.value2
            };

            // Update all count elements
            Object.keys(countElements).forEach(id => {
                const element = document.getElementById(id);
                if (element) element.value = countElements[id];
            });

            updateTotalSummaryAndCheck(totals.value1, totals.value2);
        }

        function updateTotalSummaryAndCheck(summary1, summary2) {
            summary1 = summary1 || parseFloat(document.getElementById('summary_1')?.value) || 0;
            summary2 = summary2 || parseFloat(document.getElementById('summary_2')?.value) || 0;

            const totalSummary = summary1 + summary2;

            if (document.getElementById('total_summary')) {
                document.getElementById('total_summary').value = totalSummary;
            }

            const card = document.getElementById('stuntingCard');
            const message = document.getElementById('stuntingMessage');

            if (!card || !message) return;

            // Reset card classes
            card.className = 'card';

            // Get selected criteria
            const selectedLILA = document.querySelector('input[name="lila_radio"]:checked');
            const selectedHb = document.querySelector('input[name="hb_group"]:checked');
            const selectedIMT = document.querySelector('input[name="imt_category"]:checked');

            const lilaCriteria = selectedLILA ? getLILACriteria(selectedLILA) : 'Tidak ada data';
            const hbCriteria = selectedHb ? getHbCriteria(selectedHb) : 'Tidak ada data';
            const imtCriteria = selectedIMT ? getIMTCriteria(selectedIMT) : 'Tidak ada data';

            // Get form data
            const nama = document.getElementById('nama')?.value || 'Tidak ada data';
            const umur = document.getElementById('umur')?.value || 'Tidak ada data';

            // Prepare description object for JSON storage
            const descriptionData = {
                nama: nama,
                umur: umur,
                statusLILA: lilaCriteria,
                statusHemoglobin: hbCriteria,
                statusIMT: imtCriteria,
                totalSummary: totalSummary,
                risikoStunting: totalSummary > 2 ? 'Berisiko' : 'Tidak Berisiko',
                deskripsi: totalSummary > 2 ?
                    'Hasil skrining menunjukkan bahwa Anda memiliki risiko stunting. Beberapa parameter berada di bawah batas normal. Kondisi ini memerlukan perhatian khusus untuk mencegah dampak lebih lanjut di masa depan.' : 'Hasil skrining menunjukkan bahwa Anda tidak berisiko stunting. Tetap jaga pola hidup sehat, konsumsi makanan bergizi seimbang, hindari stress, minum tablet Fe secara berkala, dan lakukan aktivitas fisik secara teratur untuk mempertahankan kondisi ini.',
                rekomendasi: totalSummary > 2 ? [
                    'Meningkatkan konsumsi makanan sesuai aturan Isi Piringku & minum tablet Fe secara berkala.',
                    'Berkonsultasi dengan tenaga kesehatan.',
                    'Melakukan pemantauan kesehatan secara berkala untuk memastikan adanya perbaikan kondisi.'
                ] : []
            };

            // Add hidden inputs for form submission
            let hiddenInputs = {
                'total_summary_input': totalSummary,
                'hasil_input': descriptionData.risikoStunting,
                'deskripsi_input': JSON.stringify(descriptionData)
            };

            // Create or update hidden inputs
            Object.keys(hiddenInputs).forEach(inputId => {
                let input = document.getElementById(inputId);
                if (!input && formElement) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.id = inputId;
                    input.name = inputId.replace('_input', '');
                    formElement.appendChild(input);
                }
                if (input) {
                    input.value = hiddenInputs[inputId];
                }
            });

            // Update the display card
            card.style.display = 'block';
            if (totalSummary > 2) {
                card.classList.add('bg-danger', 'text-white');
                message.innerHTML = buildRiskMessage(descriptionData);
            } else {
                card.classList.add('bg-success', 'text-white');
                message.innerHTML = buildNoRiskMessage(descriptionData);
            }
        }

        function buildRiskMessage(data) {
            return `
            <h5 class="card-title" style="color:white;"> <i class="bi bi-thermometer-half"></i> Berisiko Stunting</h5>
            <hr>
            <p style="color:white;">Nama: ${data.nama}</p>
            <p style="color:white;">Umur: ${data.umur} tahun</p>
            <p style="color:white;">Status LILA: ${data.statusLILA}</p>
            <p style="color:white;">Status Hemoglobin: ${data.statusHemoglobin}</p>
            <p style="color:white;">Status IMT: ${data.statusIMT}</p>
            <p style="color:white;">${data.deskripsi}</p>
            <ol>
                ${data.rekomendasi.map(rec => `<li style="color:white;">${rec}</li>`).join('')}
            </ol>
        `;
        }

        function buildNoRiskMessage(data) {
            return `
            <h5 class="card-title" style="color:white;"> <i class="bi bi-thermometer-half"></i> Tidak Berisiko Stunting</h5>
            <hr>
            <p style="color:white;">Nama: ${data.nama}</p>
            <p style="color:white;">Umur: ${data.umur} tahun</p>
            <p style="color:white;">Status LILA: ${data.statusLILA}</p>
            <p style="color:white;">Status Hemoglobin: ${data.statusHemoglobin}</p>
            <p style="color:white;">Status IMT: ${data.statusIMT}</p>
            <p style="color:white;">${data.deskripsi}</p>
        `;
        }

        // Add event listeners for all inputs
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', hitungNilai);
        });

        // Initial calculation
        hitungNilai();
    });
</script>




<!-- <script>
    // Add event listener for "Cek Sekarang" button
    document.addEventListener('DOMContentLoaded', function() {
        const cekButton = document.querySelector('.btn-primary');
        const simpanButton = document.querySelector('.btn-success');
        const stuntingCard = document.getElementById('stuntingCard');

        cekButton.addEventListener('click', function() {
            // Calculate values first
            hitungNilai();

            // Show the save button and stunting card
            simpanButton.hidden = false;
            stuntingCard.hidden = false;
        });
    });
    // Ambil elemen checkbox
    const tidakCheckbox = document.getElementById('tidak_g_1');
    const cemasCheckbox = document.getElementById('cemas_g_1');
    const tidurCheckbox = document.getElementById('tidur_g_1');
    const konsentrasiCheckbox = document.getElementById('konsentrasi_g_1');

    // Fungsi untuk menonaktifkan/mengaktifkan dan meng-uncheck checkbox lain
    function toggleOtherCheckboxes() {
        const isChecked = tidakCheckbox.checked;

        // Jika 'tidak' dicentang, uncheck dan nonaktifkan checkbox lainnya
        if (isChecked) {
            cemasCheckbox.checked = false;
            tidurCheckbox.checked = false;
            konsentrasiCheckbox.checked = false;
            cemasCheckbox.disabled = true;
            tidurCheckbox.disabled = true;
            konsentrasiCheckbox.disabled = true;
        } else {
            cemasCheckbox.disabled = false;
            tidurCheckbox.disabled = false;
            konsentrasiCheckbox.disabled = false;
        }
    }

    // Tambahkan event listener untuk memantau perubahan checkbox
    tidakCheckbox.addEventListener('change', toggleOtherCheckboxes);

    // Panggil fungsi untuk set kondisi awal
    toggleOtherCheckboxes();


    function hitungNilai() {
        // Inisialisasi counter untuk menghitung jumlah input
        let counts = {
            value0: 0,
            value1: 0,
            value2: 0
        };

        // Inisialisasi total untuk menjumlahkan nilai
        let totals = {
            value1: 0, // Untuk summary_1
            value2: 0 // Untuk summary_2
        };

        // Hitung semua input yang tercentang
        const checkedInputs = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');

        checkedInputs.forEach(input => {
            const value = parseInt(input.value);

            // Menghitung jumlah kemunculan (counting)
            if (value === 0) {
                counts.value0++;
            } else if (value === 1) {
                counts.value1++;
                totals.value1 += 1; // Menambah total nilai untuk value 1
            } else if (value === 2) {
                counts.value2++;
                totals.value2 += 2; // Menambah total nilai untuk value 2
            }
        });

        // Tampilkan hasil counting (jumlah input)
        document.getElementById('count_0').value = counts.value0; // Jumlah input dengan value 0
        document.getElementById('count_1').value = counts.value1; // Jumlah input dengan value 1
        document.getElementById('count_2').value = counts.value2; // Jumlah input dengan value 2

        // Tampilkan hasil summary (total nilai)
        document.getElementById('summary_1').value = totals.value1; // Total nilai untuk value 1
        document.getElementById('summary_2').value = totals.value2; // Total nilai untuk value 2

        // Panggil fungsi untuk memperbarui total summary dan mengecek status stunting
        updateTotalSummaryAndCheck(totals.value1, totals.value2);
    }

    function updateTotalSummaryAndCheck(summary1, summary2) {
        // Jika parameter tidak diberikan, ambil dari elemen input
        summary1 = summary1 || parseFloat(document.getElementById('summary_1').value) || 0;
        summary2 = summary2 || parseFloat(document.getElementById('summary_2').value) || 0;

        // Hitung total summary
        const totalSummary = summary1 + summary2;



        // Update total summary input field
        document.getElementById('total_summary').value = totalSummary;



        // Ambil elemen kartu dan pesan
        const card = document.getElementById('stuntingCard');
        const message = document.getElementById('stuntingMessage');

        // Reset kelas warna
        card.className = 'card';


        function getLILACriteria(selectedRadio) {
            // Mapping radio IDs to criteria
            const criteriaMap = {
                'lila_radio_1': 'Normal', // >18.5 cm (10-14 tahun)
                'lila_radio_2': 'Sedang', // 16.0-18.5 cm (10-14 tahun)
                'lila_radio_3': 'Berat', // <16.0 cm (10-14 tahun)
                'lila_radio_4': 'Normal', // >22.0 cm (15-17 tahun)
                'lila_radio_5': 'Sedang', // 18.5-22.0 cm (15-17 tahun)
                'lila_radio_6': 'Berat', // <18.5 cm (15-17 tahun)
                'lila_radio_7': 'Normal', // <23.5 cm (>18 tahun)
                'lila_radio_8': 'Berat' // >23.5 cm (>18 tahun)
            };

            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        function getHbCriteria(selectedRadio) {
            const criteriaMap = {
                'hb_radio_1': 'Normal', // <11.5 gr/dl (10-11 tahun)
                'hb_radio_2': 'Anemia Ringan', // 11.0-11.4 gr/dl (10-11 tahun)
                'hb_radio_3': 'Anemia Sedang', // 8.0-10.9 gr/dl (10-11 tahun)
                'hb_radio_4': 'Anemia Berat', // <8.0 gr/dl (10-11 tahun)

                'hb_radio_5': 'Normal', // <12 gr/dl (12-24 tahun)
                'hb_radio_6': 'Anemia Ringan', // 11.0-11.9 gr/dl (12-24 tahun)
                'hb_radio_7': 'Anemia Sedang', // 8.0-10.9 gr/dl (12-24 tahun)
                'hb_radio_8': 'Anemia Berat', // <8.0 gr/dl (12-24 tahun)

                'hb_radio_9': 'Normal', // <12 gr/dl (>15 tahun)
                'hb_radio_10': 'Anemia Ringan', // 11.0-11.9 gr/dl (>15 tahun)
                'hb_radio_11': 'Anemia Sedang', // 8.0-10.9 gr/dl (>15 tahun)
                'hb_radio_12': 'Anemia Berat' // <8.0 gr/dl (>15 tahun)
            };
            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        function getIMTCriteria(selectedRadio) {
            const criteriaMap = {
                'imt_low': 'Sangat Kurus', // < 17.0
                'imt_mild': 'Kurus', // 17-18.5
                'imt_normal': 'Normal', // 18.5-25.0
                'imt_overweight': 'Gemuk', // 25.0-27.0
                'imt_obese': 'Obesitas' // > 27.0
            };
            return criteriaMap[selectedRadio.id] || 'Tidak ada data';
        }

        // Get selected radios
        const selectedLILA = document.querySelector('input[name="lila_radio"]:checked');
        const selectedHb = document.querySelector('input[name="hb_group"]:checked');
        const selectedIMT = document.querySelector('input[name="imt_category"]:checked');

        const lilaCriteria = selectedLILA ? getLILACriteria(selectedLILA) : 'Tidak ada data';
        const hbCriteria = selectedHb ? getHbCriteria(selectedHb) : 'Tidak ada data';
        const imtCriteria = selectedIMT ? getIMTCriteria(selectedIMT) : 'Tidak ada data';



 




        if (totalSummary >= 0 && totalSummary <= 2) {
            // Ambil nilai nama dan umur dari input
            const nama = document.getElementById('nama').value || 'Tidak ada data';
            const umur = document.getElementById('umur').value || 'Tidak ada data';

            card.style.display = 'block';
            card.classList.add('bg-success', 'text-white');
            message.innerHTML = `
                                            <h5 class="card-title" style="color:white;"> <i class="bi bi-thermometer-half"></i> Tidak Berisiko Stunting</h5>
                                            <hr>
                                            <p style="color:white;">Nama: ${nama}</p>
                                            <p style="color:white;">Umur: ${umur} tahun</p>
                                            <p style="color:white;">Status LILA: ${lilaCriteria}</p>
                                            <p style="color:white;">Status Hemoglobin: ${hbCriteria}</p>
                                            <p style="color:white;">Status IMT: ${imtCriteria}</p>
                                            <p style="color:white;">Hasil skrining menunjukkan bahwa Anda tidak berisiko stunting. Tetap jaga pola hidup sehat, konsumsi makanan bergizi seimbang, hindari stress, minum tablet Fe secara berkala, dan lakukan aktivitas fisik secara teratur untuk mempertahankan kondisi ini.</p>
                                        `;
        } else if (totalSummary > 2) {
            // Ambil nilai nama dan umur dari input
            const nama = document.getElementById('nama').value || 'Tidak ada data';
            const umur = document.getElementById('umur').value || 'Tidak ada data';

            card.style.display = 'block';
            card.classList.add('bg-danger', 'text-white');
            message.innerHTML = `
                                            <h5 class="card-title" style="color:white;"> <i class="bi bi-thermometer-half"></i> Berisiko Stunting</h5>
                                            <hr>
                                            <p style="color:white;">Nama: ${nama}</p>
                                            <p style="color:white;">Umur: ${umur} tahun</p>
                                            <p style="color:white;">Status LILA: ${lilaCriteria}</p>
                                            <p style="color:white;">Status Hemoglobin: ${hbCriteria}</p>
                                            <p style="color:white;">Status IMT: ${imtCriteria}</p>
                                            <p style="color:white;">Hasil skrining menunjukkan bahwa Anda memiliki risiko stunting. Beberapa parameter berada di bawah batas normal. Kondisi ini memerlukan perhatian khusus untuk mencegah dampak lebih lanjut di masa depan. Kami merekomendasikan untuk:</p>
                                            <ol>
                                                <li>Meningkatkan konsumsi makanan sesuai aturan Isi Piringku & minum tablet Fe secara berkala.</li>
                                                <li>Berkonsultasi dengan tenaga kesehatan.</li>
                                                <li>Melakukan pemantauan kesehatan secara berkala untuk memastikan adanya perbaikan kondisi.</li>
                                            </ol>
                                        `;
        }
    }


    // Tambahkan event listener untuk semua input
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', hitungNilai);
    });

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', hitungNilai);
</script> -->

<!-- <script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const cekButton = document.querySelector('.btn-primary');
        const simpanButton = document.querySelector('.btn-success');
        const stuntingCard = document.getElementById('stuntingCard');

        // Add hidden fields dynamically
        const hiddenFields = `
        <input type="hidden" name="total_summary" id="total_summary_input">
        <input type="hidden" name="status_message" id="status_message_input">
        <input type="hidden" name="assessment_data" id="assessment_data_input">
    `;
        document.querySelector('form').insertAdjacentHTML('beforeend', hiddenFields);

        cekButton?.addEventListener('click', function() {
            hitungNilai();
            simpanButton.hidden = false;
            stuntingCard.hidden = false;
        });
    });

    function hitungNilai() {
        let counts = {
            value0: 0,
            value1: 0,
            value2: 0
        };

        let totals = {
            value1: 0,
            value2: 0
        };

        const checkedInputs = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');

        checkedInputs.forEach(input => {
            const value = parseInt(input.value);
            if (value === 0) counts.value0++;
            else if (value === 1) {
                counts.value1++;
                totals.value1 += 1;
            } else if (value === 2) {
                counts.value2++;
                totals.value2 += 2;
            }
        });

        // Update count displays
        document.getElementById('count_0').value = counts.value0;
        document.getElementById('count_1').value = counts.value1;
        document.getElementById('count_2').value = counts.value2;

        // Update summary values
        document.getElementById('summary_1').value = totals.value1;
        document.getElementById('summary_2').value = totals.value2;

        updateTotalSummaryAndCheck(totals.value1, totals.value2);
    }

    function updateTotalSummaryAndCheck(summary1, summary2) {
        const totalSummary = (summary1 || 0) + (summary2 || 0);

        // Update the total summary hidden input
        document.getElementById('total_summary_input').value = totalSummary;
        document.getElementById('total_summary').value = totalSummary;

        const card = document.getElementById('stuntingCard');
        const message = document.getElementById('stuntingMessage');

        // Reset card classes
        card.className = 'card';

        // Get all criteria
        const criteria = {
            lila: getLILACriteria(),
            hb: getHbCriteria(),
            imt: getIMTCriteria(),
            nama: document.getElementById('nama').value || 'Tidak ada data',
            umur: document.getElementById('umur').value || 'Tidak ada data'
        };

        // Determine risk status
        const isRisky = totalSummary > 2;
        const statusMessage = isRisky ? 'Berisiko Stunting' : 'Tidak Berisiko Stunting';

        // Store status message in hidden input
        document.getElementById('status_message_input').value = statusMessage;

        // Prepare assessment data
        const assessmentData = {
            nama: criteria.nama,
            umur: criteria.umur,
            status_lila: criteria.lila,
            status_hemoglobin: criteria.hb,
            status_imt: criteria.imt,
            hasil_skrining: statusMessage,
            rekomendasi: isRisky ? [
                "Meningkatkan konsumsi makanan sesuai aturan Isi Piringku & minum tablet Fe secara berkala.",
                "Berkonsultasi dengan tenaga kesehatan.",
                "Melakukan pemantauan kesehatan secara berkala untuk memastikan adanya perbaikan kondisi."
            ] : [
                "Tetap jaga pola hidup sehat, konsumsi makanan bergizi seimbang, hindari stress, minum tablet Fe secara berkala, dan lakukan aktivitas fisik secara teratur untuk mempertahankan kondisi ini."
            ]
        };

        // Store assessment data in hidden input
        document.getElementById('assessment_data_input').value = JSON.stringify(assessmentData);

        // Update card display
        card.style.display = 'block';
        card.classList.add(isRisky ? 'bg-danger' : 'bg-success', 'text-white');

        // Generate message HTML
        message.innerHTML = generateMessageHTML(criteria, statusMessage, isRisky);
    }

    function getLILACriteria() {
        const selectedLILA = document.querySelector('input[name="lila_radio"]:checked');
        const criteriaMap = {
            'lila_radio_1': 'Normal',
            'lila_radio_2': 'Sedang',
            'lila_radio_3': 'Berat',
            'lila_radio_4': 'Normal',
            'lila_radio_5': 'Sedang',
            'lila_radio_6': 'Berat',
            'lila_radio_7': 'Normal',
            'lila_radio_8': 'Berat'
        };
        return selectedLILA ? criteriaMap[selectedLILA.id] : 'Tidak ada data';
    }

    function getHbCriteria() {
        const selectedHb = document.querySelector('input[name="hb_group"]:checked');
        const criteriaMap = {
            'hb_radio_1': 'Normal',
            'hb_radio_2': 'Anemia Ringan',
            'hb_radio_3': 'Anemia Sedang',
            'hb_radio_4': 'Anemia Berat',
            'hb_radio_5': 'Normal',
            'hb_radio_6': 'Anemia Ringan',
            'hb_radio_7': 'Anemia Sedang',
            'hb_radio_8': 'Anemia Berat',
            'hb_radio_9': 'Normal',
            'hb_radio_10': 'Anemia Ringan',
            'hb_radio_11': 'Anemia Sedang',
            'hb_radio_12': 'Anemia Berat'
        };
        return selectedHb ? criteriaMap[selectedHb.id] : 'Tidak ada data';
    }

    function getIMTCriteria() {
        const selectedIMT = document.querySelector('input[name="imt_category"]:checked');
        const criteriaMap = {
            'imt_low': 'Sangat Kurus',
            'imt_mild': 'Kurus',
            'imt_normal': 'Normal',
            'imt_overweight': 'Gemuk',
            'imt_obese': 'Obesitas'
        };
        return selectedIMT ? criteriaMap[selectedIMT.id] : 'Tidak ada data';
    }

    function generateMessageHTML(criteria, statusMessage, isRisky) {
        return `
        <h5 class="card-title" style="color:white;">
            <i class="bi bi-thermometer-half"></i> ${statusMessage}
        </h5>
        <hr>
        <p style="color:white;">Nama: ${criteria.nama}</p>
        <p style="color:white;">Umur: ${criteria.umur} tahun</p>
        <p style="color:white;">Status LILA: ${criteria.lila}</p>
        <p style="color:white;">Status Hemoglobin: ${criteria.hb}</p>
        <p style="color:white;">Status IMT: ${criteria.imt}</p>
        <p style="color:white;">
            ${isRisky ? 'Hasil skrining menunjukkan bahwa Anda memiliki risiko stunting. Beberapa parameter berada di bawah batas normal. Kondisi ini memerlukan perhatian khusus untuk mencegah dampak lebih lanjut di masa depan. Kami merekomendasikan untuk:' : 'Hasil skrining menunjukkan bahwa Anda tidak berisiko stunting. Tetap jaga pola hidup sehat, konsumsi makanan bergizi seimbang, hindari stress, minum tablet Fe secara berkala, dan lakukan aktivitas fisik secara teratur untuk mempertahankan kondisi ini.'}
        </p>
        ${isRisky ? `
        <ol>
            <li>Meningkatkan konsumsi makanan sesuai aturan Isi Piringku & minum tablet Fe secara berkala.</li>
            <li>Berkonsultasi dengan tenaga kesehatan.</li>
            <li>Melakukan pemantauan kesehatan secara berkala untuk memastikan adanya perbaikan kondisi.</li>
        </ol>
        ` : ''}
    `;
    }

    // Add event listeners
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', hitungNilai);
    });
</script> -->

@endsection