<?php

namespace App\Http\Controllers;

use App\Imports\BbptuImport;
use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\Bbptu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BbptuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman BBPT/U";
        $subtitle = "Menu BBPT/U";
        $bbptu = Bbptu::all();
        // $bbptu = Cache::remember('bbptu', 60, function () {
        //     return Bbptu::all();
        // });

        return view('back.bbptu.index', compact('title', 'subtitle', 'bbptu'));
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

        Excel::import(new BbptuImport, $request->file('file'));

        return redirect('/bbptu')->with('message', 'Data berhasil diimpor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tinggi_badan' => 'required',  
            'status' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'tinggi_badan.required' => 'Tinggi Badan Wajib diisi',
            'status.required' => 'Status Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = Bbptu::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInBbptuId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'BBPT/U', $user->id, $loggedInBbptuId, null, json_encode($user));

        return redirect('/bbptu')->with('message', 'Data berhasil ditambahkan');
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
        $bbptu = Bbptu::findOrFail($id);

        return response()->json($bbptu);
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
            'tinggi_badan' => 'required',  
            'status' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'tinggi_badan.required' => 'Tinggi Badan Wajib diisi',
            'status.required' => 'Status Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        // Ambil data user yang akan diupdate
        $bbptu = Bbptu::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'BBPT/U', $bbptu->id, $loggedInUserId, json_encode($bbptu), json_encode($input));
    
        $bbptu->update($input);
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
        $bbptu = Bbptu::find($id);

        if (!$bbptu) {
            return response()->json(['message' => 'Data bbptu not found'], 404);
        }

         

        $bbptu->delete();
        $loggedInBbptuId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'BBPT/U', $id, $loggedInBbptuId, json_encode($bbptu), null);

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
