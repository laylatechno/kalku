@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
<style>
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
</style>




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

        <!-- Contact Form -->


        <div class="card">
            <div class="card-body">
                <div class="contact-form">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('home.hasil_kpsp') }}" method="POST" class="was-validated" novalidate>
                        @csrf
                        <!-- Nama Anak -->
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama Anak <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Masukkan Nama Anak"
                                    value="{{ old('nama') }}" required>
                            </div>
                            @if ($errors->has('nama'))
                            <hr>
                            <span class="text-danger d-block">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>

                        <!-- Nama Orang Tua -->
                        <div class="form-group">
                            <label class="form-label" for="nama_ortu">Nama Orang Tua <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="nama_ortu" name="nama_ortu" type="text"
                                    placeholder="Masukkan Nama Orang Tua" value="{{ old('nama_ortu') }}" required>
                            </div>
                            @if ($errors->has('nama_ortu'))
                 <hr>
                            <span class="text-danger d-block">{{ $errors->first('nama_ortu') }}</span>
                            @endif
                        </div>

                        <!-- Nomor WA -->
                        <div class="form-group">
                            <label class="form-label" for="no_wa">Nomor WA <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="no_wa" name="no_wa" type="number"
                                    placeholder="Masukkan Nomor WA" value="{{ old('no_wa') }}" required>
                            </div>
                            @if ($errors->has('no_wa'))
                            <span class="text-danger d-block">{{ $errors->first('no_wa') }}</span>
                            @endif
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="form-group">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input class="form-control" id="tanggal_lahir" name="tanggal_lahir" type="date"
                                value="{{ old('tanggal_lahir') }}" required>
                            @if ($errors->has('tanggal_lahir'))
                            <span class="text-danger d-block">{{ $errors->first('tanggal_lahir') }}</span>
                            @endif
                        </div>

                        <!-- Umur -->
                        <div class="form-group mb-3">
                            <label class="form-label" for="umur">Umur <span class="text-danger">*</span></label>
                            <select class="form-select" name="umur" id="umur" required>
                                <option value="" disabled selected>Pilih Umur (dalam bulan)</option>
                                @foreach ([3, 6, 9, 12, 15, 18, 21, 24, 30, 36, 42, 48, 54, 60, 66, 72] as $age)
                                <option value="{{ $age }}" {{ old('umur') == $age ? 'selected' : '' }}>{{ $age }} bulan</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group">
                            <label class="form-label" for="jenis_kelamin">Pilih Jenis Kelamin <span class="text-danger">*</span></label>
                            <label class="single-plan-check shadow-sm active-effect">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="male"
                                        value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                    <span class="form-check-label">Laki-laki</span>
                                </div>
                                <i class="bi bi-gender-male fz-20 ms-auto"></i>
                            </label>
                            <label class="single-plan-check shadow-sm active-effect">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="female"
                                        value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                                    <span class="form-check-label">Perempuan</span>
                                </div>
                                <i class="bi bi-gender-female fz-20 ms-auto"></i>
                            </label>
                            @if ($errors->has('jenis_kelamin'))
                            <span class="text-danger d-block mt-1">{{ $errors->first('jenis_kelamin') }}</span>
                            @endif
                        </div>

                        <!-- Wilayah Kerja Puskesmas -->
                        <div class="form-group">
                            <label class="form-label" for="wilayah_puskesmas">Wilayah Kerja Puskesmas <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="wilayah_puskesmas" name="wilayah_puskesmas" type="text"
                                    placeholder="Masukkan wilayah kerja puskesmas" value="{{ old('wilayah_puskesmas') }}" required>
                            </div>
                            @if ($errors->has('wilayah_puskesmas'))
                            <span class="text-danger d-block">{{ $errors->first('wilayah_puskesmas') }}</span>
                            @endif
                        </div>



                        <span style="font-size: 0.775em; color: rgb(209, 46, 46); font-style: italic;">* Inputan Wajib
                            Diisi</span>

                </div>
            </div>
        </div>
    </div>

    <div class="container" id="kuesioner-container" style="display: none;">
        <!-- Header Card -->
        <div id="kuesioner-content">
            <div class="card bg-primary rounded-0 rounded-top">
                <div class="card-body text-center py-3">
                    <h6 class="mb-0 text-white line-height-1">Kuesioner Pra Skrining Perkembangan (KPSP)</h6>
                </div>
            </div>
            <!-- Kuesioner Content -->
            <div class="checkout-wrapper-area">
                <div class="card">
                    <div class="card-body checkout-form" id="questions-container">
                        <!-- Pertanyaan akan dimuat di sini melalui JavaScript -->
                    </div>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-primary">Kirim Data Kuesioner</button>
            </div>
        </div>

        </form>


    </div>

    <script>
        document.getElementById('tanggal_lahir').addEventListener('change', function() {
            updateAgeAndFetchKuesioner();
        });

        document.getElementById('umur').addEventListener('change', function() {
            const selectedAge = parseInt(this.value);
            fetchKuesioner(selectedAge);
        });

        function updateAgeAndFetchKuesioner() {
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const selectedDate = new Date(tanggalLahirInput.value);
            const currentDate = new Date();

            // Hitung selisih dalam bulan
            const diffInMonths = (currentDate.getFullYear() - selectedDate.getFullYear()) * 12 +
                (currentDate.getMonth() - selectedDate.getMonth());

            const ageOptions = [3, 6, 9, 12, 15, 18, 21, 24, 30, 36, 42, 48, 54, 60, 66, 72];
            let selectedAge = ageOptions[0]; // Default umur

            for (let i = 0; i < ageOptions.length; i++) {
                if (diffInMonths >= ageOptions[i]) {
                    selectedAge = ageOptions[i];
                } else {
                    break;
                }
            }

            // Set umur yang sesuai
            const umurSelect = document.getElementById('umur');
            umurSelect.value = selectedAge;

            // Panggil fungsi fetchKuesioner
            fetchKuesioner(selectedAge);
        }

        // Fungsi untuk memuat kuesioner
        function fetchKuesioner(umur) {
            const container = document.getElementById('kuesioner-container');
            const content = document.getElementById('kuesioner-content');

            content.innerHTML = `
        <div class="card bg-primary rounded-0 rounded-top">
            <div class="card-body text-center py-3">
                <p class="mb-0 text-white line-height-1">Memuat pertanyaan...</p>
            </div>
        </div>`;

            fetch(`/kpsp/${umur}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        content.innerHTML = `
                    <div class="card bg-primary rounded-0 rounded-top">
                        <div class="card-body text-center py-3">
                            <h6 class="mb-0 text-white line-height-1">Kuesioner Pra Skrining Perkembangan (KPSP) <br>Bayi Umur ${umur} Bulan</h6>
                        </div>
                    </div>
                    <div class="checkout-wrapper-area">
                        <div class="card">
                            <div class="card-body checkout-form" id="questions-container"></div>
                        </div>
                    </div>`;

                        const questionsContainer = document.getElementById('questions-container');

                        data.forEach((item, index) => {
                            const questionDiv = document.createElement('div');
                            questionDiv.innerHTML = `
                            <h6>${index + 1}. ${item.pertanyaan}</h6>
                            <span class="badge bg-${item.warna} mb-3">Kategori: ${item.kategori}</span>
                            ${item.gambar ? `
                            <a class="mb-2" href="/upload/kpsp/${item.gambar}" target="_blank">
                                <img style="max-width:100px; max-height:100px; display:block; margin-top:5px; margin-bottom:10px;" 
                                    src="/upload/kpsp/${item.gambar}" alt="Gambar KPSP">
                            </a>` : ''}
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban[${item.id}]" value="Ya" id="yes_${item.id}" required>
                                <label class="form-check-label" for="yes_${item.id}">Ya</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban[${item.id}]" value="Tidak" id="no_${item.id}" required>
                                <label class="form-check-label" for="no_${item.id}" style="color: red;">Tidak</label>
                            </div>
                            <hr>`;
                            questionsContainer.appendChild(questionDiv);
                        });

                    } else {
                        content.innerHTML = `
                    <div class="card bg-primary rounded-0 rounded-top">
                        <div class="card-body text-center py-3">
                            <p class="mb-0 text-white line-height-1">Tidak ada pertanyaan untuk umur ini.</p>
                        </div>
                    </div>`;
                    }
                    container.style.display = 'block';
                })
                .catch(error => {
                    content.innerHTML = `
                <div class="card bg-primary rounded-0 rounded-top">
                    <div class="card-body text-center py-3">
                        <p class="mb-0 text-white line-height-1">Error saat memuat pertanyaan.</p>
                    </div>
                </div>`;
                    console.error(error);
                });
        }
    </script>



    <!-- <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Kumpulkan jawaban
            const answers = {};
            const radioButtons = document.querySelectorAll('#questions-container input[type="radio"]:checked');

            radioButtons.forEach(radio => {
                const questionId = radio.name.match(/\[(\d+)\]/)[1];
                answers[questionId] = radio.value;
            });

            // Buat FormData
            const formData = new FormData(this);
            formData.set('jawaban', JSON.stringify(answers));

            // Kirim data
            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data.');
                });
        });
    </script> -->
    <script>
        // Get all form inputs that are required
        function validateForm(e) {
            e.preventDefault();

            // Get all required inputs
            const requiredInputs = document.querySelectorAll('input[required], select[required]');
            let isValid = true;
            let firstInvalidElement = null;

            // Remove existing error messages
            document.querySelectorAll('.validation-error').forEach(el => el.remove());

            // Check each required input
            requiredInputs.forEach(input => {
                if (input.type === 'radio') {
                    // For radio buttons, check if any in the group is checked
                    const groupName = input.name;
                    const radioGroup = document.querySelectorAll(`input[name="${groupName}"]:checked`);
                    if (radioGroup.length === 0) {
                        const radioContainer = input.closest('.form-group');
                        if (!radioContainer.querySelector('.validation-error')) {
                            const error = document.createElement('div');
                            error.className = 'validation-error text-danger mt-1';
                            error.style.fontSize = '0.875em';
                            error.textContent = 'Pilihan ini wajib diisi';
                            radioContainer.appendChild(error);
                        }
                        isValid = false;
                        if (!firstInvalidElement) firstInvalidElement = input;
                    }
                } else if (!input.value.trim()) {
                    // For other inputs, check if they have a value
                    const error = document.createElement('div');
                    error.className = 'validation-error text-danger mt-1';
                    error.style.fontSize = '0.875em';
                    error.textContent = 'Bidang ini wajib diisi tidak boleh kosong';
                    input.parentNode.appendChild(error);
                    isValid = false;
                    if (!firstInvalidElement) firstInvalidElement = input;
                }
            });

            // Check questionnaire answers if they're visible
            const questionnaireContainer = document.getElementById('kuesioner-container');
            if (questionnaireContainer && questionnaireContainer.style.display !== 'none') {
                const questions = document.querySelectorAll('#questions-container .form-check-input[required]');
                questions.forEach(question => {
                    const questionGroup = document.querySelectorAll(`input[name="${question.name}"]:checked`);
                    if (questionGroup.length === 0) {
                        const questionContainer = question.closest('div').parentNode;
                        if (!questionContainer.querySelector('.validation-error')) {
                            const error = document.createElement('div');
                            error.className = 'validation-error text-danger mt-1';
                            error.style.fontSize = '0.875em';
                            error.textContent = 'Pertanyaan ini wajib dijawab';
                            questionContainer.appendChild(error);
                        }
                        isValid = false;
                        if (!firstInvalidElement) firstInvalidElement = question;
                    }
                });
            }

            // If form is not valid, scroll to first invalid element
            if (!isValid) {
                firstInvalidElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            }

            // If form is valid, proceed with form submission
            const formData = new FormData(document.querySelector('form'));
            const answers = {};
            const radioButtons = document.querySelectorAll('#questions-container input[type="radio"]:checked');

            radioButtons.forEach(radio => {
                const questionId = radio.name.match(/\[(\d+)\]/)[1];
                answers[questionId] = radio.value;
            });

            formData.set('jawaban', JSON.stringify(answers));

            fetch(document.querySelector('form').action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data.');
                });

            return false;
        }

        // Add event listener to form
        document.querySelector('form').addEventListener('submit', validateForm);
    </script>

</div>

{{-- Tampilkan form KPSP seperti biasa --}}

@if($hasil)
<div class="container" style="margin-top: -30px;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0" style="color: white;">Hasil KPSP Terakhir</h5>
        </div>
        <!-- Tombol Print -->


        <div class="card unhide">
            <div class="card-body text-center">
                <button class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer"></i> Simpan/Cetak
                </button>
                <a href="/kpsp">
                    <button class="btn btn-warning btn-sm">
                        <i class="bi bi-arrow-return-left"></i> Kembali
                    </button>
                </a>

            </div>
        </div>
        <div class="card-body">
            <!-- Data Diri -->
            <div class="mb-3" style="margin-top: -10px;">
                <h6>Data Diri</h6>
                <table class="table table-borderless">
                    <tr>
                        <td width="150">Nama</td>
                        <td width="20">:</td>
                        <td>{{ $hasil->nama }}</td>
                    </tr>
                    <tr>
                        <td width="150">Nama Ortu</td>
                        <td width="20">:</td>
                        <td>{{ $hasil->nama_ortu }}</td>
                    </tr>
                    <tr>
                        <td width="150">No WA</td>
                        <td width="20">:</td>
                        <td>{{ $hasil->no_wa }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($hasil->tanggal_lahir)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>:</td>
                        <td>{{ $hasil->umur }} bulan</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $hasil->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Wilayah Puskesmas</td>
                        <td>:</td>
                        <td>{{ $hasil->wilayah_puskesmas }}</td>
                    </tr>
                </table>
            </div>

            <!-- Hasil Jawaban -->
            <div class="mb-3">
                <h6>Hasil Jawaban</h6>
                @foreach($pertanyaan as $key => $item)
                <div class="mb-3">
                    <p class="mb-1">{{ $key + 1 }}. {{ $item->pertanyaan }}</p>
                    <span class="badge bg-{{ $item->warna }} mb-2">Kategori: {{ $item->kategori }}</span>
                    <p class="mb-0">Jawaban: <span class="fw-bold {{ $jawaban[$item->id] === 'Ya' ? 'text-success' : 'text-danger' }}">{{ $jawaban[$item->id] }}</span></p>
                    <hr>
                </div>
                @endforeach
            </div>

            <!-- Hasil Interpretasi -->
            <div class="text-center">
                <h6>Hasil Interpretasi</h6>
                <div class="alert {{ $hasil->interpretasi === 'SESUAI UMUR' ? 'alert-success' : ($hasil->interpretasi === 'MERAGUKAN' ? 'alert-warning' : 'alert-danger') }}">
                    <p class="mb-0">Total Jawaban "Ya": {{ $hasil->total_ya }}</p>
                    <h5 class="mt-2 mb-0">{{ $hasil->interpretasi }}</h5>
                </div>
            </div>

            <!-- Rekomendasi -->
            @if($hasil->interpretasi === 'SESUAI UMUR')
            <div class="mt-3">
                <h6>Rekomendasi:</h6>
                <p>Selamat! Hasil penilaian menunjukkan bahwa perkembangan Ananda berada dalam kategori sesuai dengan usia. Hal ini menandakan bahwa Ananda berkembang dengan baik dalam aspek motorik kasar, motorik halus, bahasa, dan sosialisasi & kemandirian. Tetap dukung tumbuh kembang anak Anda dengan memberikan stimulasi yang sesuai, seperti bermain aktif, dan berinteraksi secara positif. Pastikan untuk memantau perkembangannya secara rutin.</p>
            </div>
            @elseif($hasil->interpretasi === 'MERAGUKAN')
            <div class="mt-3">
                <h6>Rekomendasi:</h6>
                <p>Hasil penilaian menunjukkan bahwa perkembangan anak Anda berada dalam kategori meragukan. Hal ini mengindikasikan adanya beberapa area perkembangan yang perlu mendapatkan perhatian lebih. Kami merekomendasikan:</p>
                <ul>
                    <li>1. Memberikan stimulasi tambahan sesuai dengan area perkembangan yang memerlukan dukungan, seperti motorik, bahasa, atau sosialisasi dan kemandirian.</li>
                    <li>2. Melakukan penilaian ulang dalam 2-4 minggu untuk memastikan perkembangan anak.</li>
                    <li>3. Berkonsultasi dengan tenaga kesehatan.</li>



                </ul>
            </div>
            @else
            <div class="mt-3">
                <h6>Rekomendasi:</h6>
                <p>Hasil penilaian menunjukkan bahwa perkembangan anak Anda berada dalam kategori penyimpangan. Kami menyarankan Anda untuk segera mengambil langkah-langkah berikut:</p>
                <ul>
                    <li>1. Mengonsultasikan hasil ini dengan dokter spesialis anak atau psikolog perkembangan untuk evaluasi lebih lanjut.</li>
                    <li>2. Melakukan stimulasi intensif di rumah dengan aktivitas yang mendukung perkembangan anak sesuai usianya.</li>
                    <li>3. Memastikan anak mendapatkan perhatian khusus untuk mendukung pertumbuhannya secara holistik..</li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endif














@endsection