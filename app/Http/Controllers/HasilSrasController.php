<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\HasilSras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class HasilSrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Hasil SRAS";
        $subtitle = "Menu Hasil SRAS";
        $hasil_sras = HasilSras::all();
    
        return view('back.hasil_sras.index', compact('title', 'subtitle', 'hasil_sras'));
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
        $hasil_sras = HasilSras::findOrFail($id);

        return response()->json($hasil_sras);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hasil_hitung = HasilSras::find($id);

        if (!$hasil_hitung) {
            return response()->json(['message' => 'Data hasil_hitung not found'], 404);
        }

        $oldpictureFileName = $hasil_hitung->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);

        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $hasil_hitung->delete();
        $loggedInHasilSrasId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Hasil Hitung', $id, $loggedInHasilSrasId, json_encode($hasil_hitung), null);

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
