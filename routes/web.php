<?php

use App\Http\Controllers\AlasanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KategoriGaleriController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LogHistoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BbptuController;
use App\Http\Controllers\BbuController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\HasilHitungController;
use App\Http\Controllers\HasilKpspController;
use App\Http\Controllers\HasilSrasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImtController;
use App\Http\Controllers\KpspController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PtbuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HtmlMinifier;

// Redirect Home jika dia Guest
Route::get('/home', function () {
    return redirect('/dashboard');
});


Route::middleware([HtmlMinifier::class])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/edunika', [HomeController::class, 'edunika']);
    Route::get('/info', [HomeController::class, 'info']);

    Route::get('/kpsp', [HomeController::class, 'kpsp'])->name('kpsp');
    Route::get('/kpsp/{umur}', [HomeController::class, 'getKuesionerByUmur']);
    Route::post('/hasil-kpsp', [HomeController::class, 'hasil_kpsp'])->name('home.hasil_kpsp');
    Route::get('/hasil-kpsp/{id}', [HomeController::class, 'show_hasil_kpsp'])->name('show.hasil_kpsp');

    Route::get('/sras', [HomeController::class, 'sras'])->name('sras');
    Route::post('/hasil-sras', [HomeController::class, 'hasil_sras'])->name('home.hasil_sras');


    Route::get('/edunika/{slug}', [HomeController::class, 'edunika_detail'])->name('edunika.edunika_detail');
    Route::get('/video_kalkulating', [HomeController::class, 'video']);
    Route::get('/galeri_pengguna', [HomeController::class, 'galeri_pengguna']);

    // Halaman Depan Isi Gizi
    Route::get('/hitung_gizi', [HomeController::class, 'hitung_gizi'])->name('hitung_gizi');
    Route::post('/proses_gizi', [GiziController::class, 'determineStatus'])->name('proses_gizi.determine');
});


Route::middleware(['guest'])->group(function () {
    Route::get('/auth', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/logout ', [AuthController::class, 'logout'])->name('auth.logout');

    // User
    Route::resource('users', UserController::class);

    // Log History
    Route::resource('log_histori', LogHistoriController::class);
    Route::get('/log-histori/delete-all', [LogHistoriController::class, 'deleteAll'])->name('log-histori.delete-all');

    // Route::get('/backup/download', [BackupController::class, 'createBackup'])->name('backup.download');

    Route::get('/backup', [BackupController::class, 'createBackup'])->name('backup.create');


    // Profil Perusahaan
    Route::resource('profil', ProfilController::class)->middleware('auth');
    Route::put('/profil/update_media_sosial/{id}', [ProfilController::class, 'update_media_sosial'])->name('profil.update_media_sosial');
    Route::put('/profil/update_umum/{id}', [ProfilController::class, 'update_umum'])->name('profil.update_umum');
    Route::put('/profil/update_sdm/{id}', [ProfilController::class, 'update_sdm'])->name('profil.update_sdm');
    Route::put('/profil/update_display/{id}', [ProfilController::class, 'update_display'])->name('profil.update_display');

    // Produk
    Route::resource('kategori_produk', KategoriProdukController::class);
    // Route::get('produk/datatables', [ProdukController::class, 'index'])->name('produk.datatables');

    Route::get('datatables/produk', [ProdukController::class, 'getProdukDatatables'])->name('datatables.produk');
    Route::resource('produk', ProdukController::class);

    // Berita
    Route::resource('kategori_berita', KategoriBeritaController::class);
    Route::resource('berita', BeritaController::class);

    // Galeri
    Route::resource('kategori_galeri', KategoriGaleriController::class);
    Route::resource('galeri', GaleriController::class);

    // Slider
    Route::resource('slider', SliderController::class);

    // Layanan
    Route::resource('layanan', LayananController::class);

    // Alasan
    Route::resource('alasan', AlasanController::class);

    // Testimoni
    Route::resource('testimoni', TestimoniController::class);

    // Video
    Route::resource('video', VideoController::class);

    // Hasil Hitung
    Route::resource('hasil_hitung', HasilHitungController::class);
    Route::resource('hasil_kpsp', HasilKpspController::class);
    Route::resource('hasil_sras', HasilSrasController::class);

    // Data Pertanyaan
    Route::resource('data_kpsp', KpspController::class);

    // Bbu
    Route::resource('bbu', BbuController::class);
    Route::post('/bbu/import', [BbuController::class, 'import'])->name('bbu.import');

    // Ptbu
    Route::resource('ptbu', PtbuController::class);
    Route::post('/ptbu/import', [PtbuController::class, 'import'])->name('ptbu.import');
    // Bbptu
    Route::resource('bbptu', BbptuController::class);
    Route::post('/bbptu/import', [BbptuController::class, 'import'])->name('bbptu.import');

    // Bbptu
    Route::resource('imt', ImtController::class);
    Route::post('/imt/import', [ImtController::class, 'import'])->name('imt.import');
});
