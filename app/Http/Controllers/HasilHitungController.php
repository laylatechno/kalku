<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\HasilHitung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class HasilHitungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Hasil Hitung";
        $subtitle = "Menu Hasil Hitung";
        $hasil_hitung = HasilHitung::all();
        // $hasil_hitung = Cache::remember('hasil_hitung', 60, function () {
        //     return HasilHitung::all();
        // });

        return view('back.hasil_hitung.index', compact('title', 'subtitle', 'hasil_hitung'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hasil_hitung' => 'required|unique:hasil_hitung,nama_hasil_hitung', // Nama kategori berita harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_hasil_hitung.required' => 'Nama Hasil Hitung Wajib diisi',
            'nama_hasil_hitung.unique' => 'Nama Hasil Hitung sudah terdaftar',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = HasilHitung::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInHasilHitungId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Hasil Hitung', $user->id, $loggedInHasilHitungId, null, json_encode($user));

        return redirect('/hasil_hitung')->with('message', 'Data berhasil ditambahkan');
    }




    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hasil_hitung = HasilHitung::findOrFail($id);

        return response()->json($hasil_hitung);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_hasil_hitung' => 'required', // Nama kategori berita harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_hasil_hitung.required' => 'Nama Hasil Hitung Wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        // Ambil data user yang akan diupdate
        $hasil_hitung = HasilHitung::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Hasil Hitung', $hasil_hitung->id, $loggedInUserId, json_encode($hasil_hitung), json_encode($input));
    
        $hasil_hitung->update($input);
        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hasil_hitung = HasilHitung::find($id);

        if (!$hasil_hitung) {
            return response()->json(['message' => 'Data hasil_hitung not found'], 404);
        }

        $oldpictureFileName = $hasil_hitung->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);

        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $hasil_hitung->delete();
        $loggedInHasilHitungId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Hasil Hitung', $id, $loggedInHasilHitungId, json_encode($hasil_hitung), null);

        return response()->json(['message' => 'Data Berhasil Dihapus']);
    }

    // Fungsi untuk menyimpan log histori
    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        $log = new LogHistori();
        $log->tabel_asal = $tabelAsal;
        $log->id_entitas = $idEntitas;
        $log->aksi = $aksi;
        $log->waktu = now(); // Menggunakan waktu saat ini
        $log->pengguna = $pengguna;
        $log->data_lama = $dataLama;
        $log->data_baru = $dataBaru;
        $log->save();
    }
}
