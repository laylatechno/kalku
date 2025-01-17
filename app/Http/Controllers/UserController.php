<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman User";
        $subtitle = "Menu User";
        // $users = User::all();
        $users = Cache::remember('users', 60, function () {
            return User::all();
        });

        return view('back.users.index', compact('title', 'subtitle', 'users'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // Email harus unik
            'password' => 'required|min:6', // Minimal 6 karakter
            'role' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
        ], [
            'name.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password Wajib diisi',
            'password.min' => 'Password minimal harus terdiri dari 6 karakter',
            'role.required' => 'Role Wajib diisi',
            'picture.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'picture.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'picture.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);


        $input = $request->all();

        if ($image = $request->file('picture')) {
            $destinationPath = 'upload/user/';

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
                    $input['picture'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        } else {
            // Set nilai default untuk picture jika tidak ada gambar yang diunggah
            $input['picture'] = '';
        }


        // Hash password
        $input['password'] = Hash::make($request->password);

        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = User::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'User', $user->id, $loggedInUserId, null, json_encode($user));

        return redirect('/users')->with('message', 'Data berhasil ditambahkan');
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
        $users = User::findOrFail($id);

        return response()->json($users);
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
             'name' => 'required',
             'email' => [
                 'required',
                 'email',
                 Rule::unique('users')->ignore($id), // Menambahkan aturan unik dengan pengecualian
             ],
             'password' => 'nullable|min:6', // Password hanya wajib saat membuat, tidak saat update
             'role' => 'required',
             'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
         ], [
             'name.required' => 'Nama Wajib diisi',
             'email.required' => 'Email Wajib diisi',
             'email.email' => 'Format email tidak valid',
             'email.unique' => 'Email sudah terdaftar',
             'password.min' => 'Password minimal harus terdiri dari 6 karakter',
             'role.required' => 'Role Wajib diisi',
             'picture.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
             'picture.mimes' => 'Format gambar harus jpeg, jpg, atau png',
             'picture.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
         ]);
     
         // Ambil data user yang akan diupdate
         $user = User::findOrFail($id);
     
         // Setel data yang akan diupdate
         $input = $request->all();
     
         // Cek apakah password diisi dan hash password baru jika diisi
         if ($request->filled('password')) {
             $input['password'] = Hash::make($request->input('password'));
         } else {
             // Jika password tidak diisi, hapus dari input agar tidak mengubahnya di database
             unset($input['password']);
         }
     
         // Cek apakah gambar diupload
         if ($request->hasFile('picture')) {
             // Hapus gambar sebelumnya jika ada
             $oldPictureFileName = $user->picture;
             if ($oldPictureFileName) {
                 $oldFilePath = public_path('upload/user/' . $oldPictureFileName);
                 if (file_exists($oldFilePath)) {
                     unlink($oldFilePath);
                 }
             }
     
             $image = $request->file('picture');
             $destinationPath = 'upload/user/';
     
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
     
                     // Simpan hanya nama file gambar ke dalam atribut user
                     $input['picture'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                 } else {
                     // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                 }
             } else {
                 // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
             }
         }
     
         // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
         $user = User::findOrFail($id);
    
         // Mendapatkan ID pengguna yang sedang login
         $loggedInUserId = Auth::id();
     
         // Simpan log histori untuk operasi Update dengan user_id yang sedang login
         $this->simpanLogHistori('Update', 'User', $user->id, $loggedInUserId, json_encode($user), json_encode($input));
     
         $user->update($input);
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
        $users = User::find($id);

        if (!$users) {
            return response()->json(['message' => 'Data users not found'], 404);
        }

        $oldpictureFileName = $users->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);

        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $users->delete();
        $loggedInUserId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'users', $id, $loggedInUserId, json_encode($users), null);

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
