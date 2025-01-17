<?php

namespace App\Http\Controllers;

use App\Imports\ImtImport;
use App\Models\LogHistori;
use App\Models\Imt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ImtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman IMT";
        $subtitle = "Menu IMT";
        $imt = Imt::all();
        // $imt = Cache::remember('imt', 60, function () {
        //     return Imt::all();
        // });

        return view('back.imt.index', compact('title', 'subtitle', 'imt'));
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

        Excel::import(new ImtImport, $request->file('file'));

        return redirect('/imt')->with('message', 'Data berhasil diimpor');
    }


    public function store(Request $request)
    {
        $request->validate([
            'umur' => 'required',  
            'status' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'umur.required' => 'Umur Wajib diisi',
            'status.required' => 'Status Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = Imt::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInImtId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'IMT', $user->id, $loggedInImtId, null, json_encode($user));

        return redirect('/imt')->with('message', 'Data berhasil ditambahkan');
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
        $imt = Imt::findOrFail($id);

        return response()->json($imt);
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
            'status' => 'required',  
            'jenis_kelamin' => 'required',  
        ], [
            'umur.required' => 'Umur Wajib diisi',
            'status.required' => 'Status Wajib diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib diisi',
        ]);
        // Ambil data user yang akan diupdate
        $imt = Imt::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'IMT', $imt->id, $loggedInUserId, json_encode($imt), json_encode($input));
    
        $imt->update($input);
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
        $imt = Imt::find($id);

        if (!$imt) {
            return response()->json(['message' => 'Data imt not found'], 404);
        }

         

        $imt->delete();
        $loggedInImtId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'IMT', $id, $loggedInImtId, json_encode($imt), null);

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
