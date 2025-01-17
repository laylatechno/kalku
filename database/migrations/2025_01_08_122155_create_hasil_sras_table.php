<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_sras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('lila');
            $table->string('berat_badan');
            $table->string('tinggi_badan');
            $table->string('hb');
            $table->string('sekolah');
            $table->integer('total');  //isi total_summary/totalSummary
            $table->string('hasil'); //diambil dari h5 (<h5 class="card-title" style="color:white;"> <i class="bi bi-thermometer-half"></i> Tidak Berisiko Stunting</h5>)
            $table->json('deskripsi'); //kalau jawab diambil dari  
            // <hr>
            // <p style="color:white;">Nama: ${nama}</p>
            // <p style="color:white;">Umur: ${umur} tahun</p>
            // <p style="color:white;">Status LILA: ${lilaCriteria}</p>
            // <p style="color:white;">Status Hemoglobin: ${hbCriteria}</p>
            // <p style="color:white;">Status IMT: ${imtCriteria}</p>
            // <p style="color:white;">Hasil skrining menunjukkan bahwa Anda tidak berisiko stunting. Tetap jaga pola hidup sehat, konsumsi makanan bergizi seimbang, hindari stress, minum tablet Fe secara berkala, dan lakukan aktivitas fisik secara teratur untuk mempertahankan kondisi ini.</p>

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_sras');
    }
};
