<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
// use Yajra\DataTables\Facades\DataTables;


use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{




    public function index()
    {
        $title = "Halaman Produk";
        $subtitle = "Menu Produk";
        $kategoriProduk = KategoriProduk::all();
        return view('back.produk.index', compact('title', 'subtitle','kategoriProduk'));
    }

     
 

    public function getProdukDatatables(Request $request)
    {
        if ($request->ajax()) {
            $data = Produk::with('kategoriProduk')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($p) {
                    return $p->kategoriProduk->nama_kategori_produk ?? 'Tidak ada kategori';
                })
                ->addColumn('aksi', function ($p) {
                    $editBtn = '<a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                    data-target="#modal-edit" data-id="' . $p->id . '" style="color: black">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';
                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-hapus" data-id="' . $p->id . '"
                                    style="color: white">
                                    <i class="fas fa-trash"></i> Delete
                                </button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return response()->json(['error' => 'Unauthorized access'], 403); // Menangani akses tidak sah
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
            'nama_produk' => 'required|min:4',
            'kategori_produk_id' => 'required',
            'harga_beli' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'stok' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:6144',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori_produk_id.required' => 'Kategori produk wajib diisi',
            'harga_beli.numeric' => 'Harga beli harus berupa angka',
            'harga_jual.numeric' => 'Harga jual harus berupa angka',
            'stok.numeric' => 'Stok harus berupa angka',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);

        $input = $request->all();

        if ($image = $request->file('gambar')) {
            $destinationPath = 'upload/produk/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file gambar
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME gambar yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan gambar asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path gambar asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan gambar WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca gambar asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    default:
                        // Jenis MIME tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                        // Misalnya, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
                        break;
                }

                // Jika gambar asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat gambar baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus gambar asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file gambar ke dalam array input
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        } else {
            // Set nilai default untuk gambar jika tidak ada gambar yang diunggah
            $input['gambar'] = '';
        }




        // Membuat produk baru dan mendapatkan data pengguna yang baru dibuat
        $produk = Produk::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInProdukId = Auth::id();

        // Simpan log histori untuk operasi Create dengan produk_id yang sedang login
        $this->simpanLogHistori('Create', 'Produk', $produk->id, $loggedInProdukId, null, json_encode($produk));

        return redirect('/produk')->with('message', 'Data berhasil ditambahkan');
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
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json($produk);
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
            'nama_produk' => 'required|min:4',
            'kategori_produk_id' => 'required',
            'harga_beli' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'stok' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:6144',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori_produk_id.required' => 'Kategori produk wajib diisi',
            'harga_beli.numeric' => 'Harga beli harus berupa angka',
            'harga_jual.numeric' => 'Harga jual harus berupa angka',
            'stok.numeric' => 'Stok harus berupa angka',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);

        // Ambil data produk yang akan diupdate
        $produk = Produk::findOrFail($id);

        // Setel data yang akan diupdate
        $input = $request->all();


        // Cek apakah gambar diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar sebelumnya jika ada
            $oldPictureFileName = $produk->gambar;
            if ($oldPictureFileName) {
                $oldFilePath = public_path('upload/produk/' . $oldPictureFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('gambar');
            $destinationPath = 'upload/produk/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file gambar
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME gambar yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan gambar asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path gambar asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan gambar WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca gambar asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    default:
                        // Jenis MIME tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                        // Misalnya, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
                        break;
                }

                // Jika gambar asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat gambar baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus gambar asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file gambar ke dalam atribut produk
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        }

        // Membuat produk baru dan mendapatkan data pengguna yang baru dibuat
        $produk = Produk::findOrFail($id);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInProdukId = Auth::id();

        // Simpan log histori untuk operasi Update dengan produk_id yang sedang login
        $this->simpanLogHistori('Update', 'Produk', $produk->id, $loggedInProdukId, json_encode($produk), json_encode($input));

        $produk->update($input);
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
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Data produk not found'], 404);
        }

        $oldgambarFileName = $produk->file; // Nama file saja
        $oldfilePath = public_path('upload/produk/' . $oldgambarFileName);

        if ($oldgambarFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $produk->delete();
        $loggedInProdukId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan produk_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'produk', $id, $loggedInProdukId, json_encode($produk), null);

        return response()->json(['message' => 'Data Berhasil Dihapus']);
    }

    // ========================================= Rubah jika ada relasi ke tabel lain

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
