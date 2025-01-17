<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\Bbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Imports\BbuImport;
use Maatwebsite\Excel\Facades\Excel;
 
 

class BbuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman BB/U";
        $subtitle = "Menu BB/U";
        $bbu = Bbu::all();
        // $bbu = Cache::remember('bbu', 60, function () {
        //     return Bbu::all();
        // });

        return view('back.bbu.index', compact('title', 'subtitle', 'bbu'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new BbuImport, $request->file('file'));

        return redirect('/bbu')->with('message', 'Data berhasil diimpor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'umur' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'nama_bbu.required' => 'Nama Kategori Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = Bbu::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInBbuId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'BB/U', $user->id, $loggedInBbuId, null, json_encode($user));

        return redirect('/bbu')->with('message', 'Data berhasil ditambahkan');
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
        $bbu = Bbu::findOrFail($id);

        return response()->json($bbu);
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
        $request->validate([
            'umur' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'nama_bbu.required' => 'Nama Kategori Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        // Ambil data user yang akan diupdate
        $bbu = Bbu::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'BB/U', $bbu->id, $loggedInUserId, json_encode($bbu), json_encode($input));
    
        $bbu->update($input);
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
        $bbu = Bbu::find($id);

        if (!$bbu) {
            return response()->json(['message' => 'Data bbu not found'], 404);
        }

         

        $bbu->delete();
        $loggedInBbuId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'BB/U', $id, $loggedInBbuId, json_encode($bbu), null);

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
