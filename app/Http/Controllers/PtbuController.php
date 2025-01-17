<?php

namespace App\Http\Controllers;

use App\Imports\PtbuImport;
use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\Ptbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PtbuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman PTB/U";
        $subtitle = "Menu PTB/U";
        $ptbu = Ptbu::all();
        // $ptbu = Cache::remember('ptbu', 60, function () {
        //     return Ptbu::all();
        // });

        return view('back.ptbu.index', compact('title', 'subtitle', 'ptbu'));
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

        Excel::import(new PtbuImport, $request->file('file'));

        return redirect('/ptbu')->with('message', 'Data berhasil diimpor');
    }


    public function store(Request $request)
    {
        $request->validate([
            'umur' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'nama_ptbu.required' => 'Nama Kategori Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = Ptbu::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInPtbuId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'PTB/U', $user->id, $loggedInPtbuId, null, json_encode($user));

        return redirect('/ptbu')->with('message', 'Data berhasil ditambahkan');
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
        $ptbu = Ptbu::findOrFail($id);

        return response()->json($ptbu);
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
            'nama_ptbu.required' => 'Nama Kategori Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        // Ambil data user yang akan diupdate
        $ptbu = Ptbu::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'PTB/U', $ptbu->id, $loggedInUserId, json_encode($ptbu), json_encode($input));
    
        $ptbu->update($input);
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
        $ptbu = Ptbu::find($id);

        if (!$ptbu) {
            return response()->json(['message' => 'Data ptbu not found'], 404);
        }

         

        $ptbu->delete();
        $loggedInPtbuId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'PTB/U', $id, $loggedInPtbuId, json_encode($ptbu), null);

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
