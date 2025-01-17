@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Catering Pro - {{ $subtitle }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                
                 <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $count_berita }} </h3>

                        <p>Berita</p>
                    </div>
                    <div class="icon">
                        <i class="ion-android-boat"></i>
                    </div>
                    <a href="/berita" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $count_video }} </h3>

                        <p>Video</p>
                    </div>
                    <div class="icon">
                        <i class="ion-android-folder-open"></i>
                    </div>
                    <a href="/video" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $count_slider }} </h3>

                        <p>Slider</p>
                    </div>
                    <div class="icon">
                        <i class="ion-android-chat"></i>
                    </div>
                    <a href="/slider" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $count_user }} </h3>

                        <p>User</p>
                    </div>
                    <div class="icon">
                       
                        <i class="ion-android-contacts"></i>
                    </div>
                    <a href="/users" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.row -->




         <!-- Section for the Gender-based Chart -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Grafik Data Pengguna/Anak Berdasarkan Jenis Kelamin
                </div>
                <div class="card-body">
                    <canvas id="genderChartAnak"></canvas> <!-- Periksa apakah ID cocok -->
                </div>
            </div>
        </div>

       

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Kunjungan Website
                </div>
                <div class="card-body">
                    <canvas id="visitors"></canvas>
                </div>
            </div>
        </div>

    </div>

   


              
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
 
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var visitData = @json($visits); // Data dari controller

        var dates = visitData.map(v => v.date); // Ambil tanggal
        var counts = visitData.map(v => v.count); // Ambil jumlah kunjungan

        var ctx = document.getElementById("visitors").getContext("2d");

        new Chart(ctx, {
            type: 'line', // Grafik garis
            data: {
                labels: dates, // Label sumbu-x
                datasets: [{
                    label: 'Kunjungan',
                    data: counts, // Data sumbu-y
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                    borderWidth: 1, // Lebar garis
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true, // Mulai sumbu-y dari nol
                    },
                },
            },
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data for Siswa Chart
        var genderDataSiswa = @json($gender_data_anak);

        var chartDataSiswa = {
            labels: Object.keys(genderDataSiswa), // 'Laki-laki', 'Perempuan'
            datasets: [{
                label: 'Jumlah Anak',
                data: Object.values(genderDataSiswa), // [count_laki, count_perempuan]
                backgroundColor: ['#3498db', '#e74c3c'], // Colors for the bars
            }]
        };

        var ctxSiswa = document.getElementById("genderChartAnak").getContext("2d");

        new Chart(ctxSiswa, {
            type: 'bar', // Use a bar chart
            data: chartDataSiswa,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true // Start the y-axis at zero
                    }
                }
            }
        });

       
    });
</script>

@endsection
