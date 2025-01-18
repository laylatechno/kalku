<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Alasan;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\HasilKpsp;
use App\Models\KategoriProduk;
use App\Models\Kpsp;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Visitor;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent; // Pustaka untuk mengurai user-



class HomeController extends Controller
{
    public function index()
    {
        $title = "Halaman Beranda Kalkulating";
        $subtitle = "Menu Beranda Kalkulating";
        $agent = new Agent(); // Buat instance untuk mengurai user-agent

        // Simpan visitor
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $visit_time = date('Y-m-d H:i:s');
        $session_id = session_id(); // Ambil ID sesi
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Ambil informasi tentang perangkat dan OS
        $device = $agent->device(); // Nama perangkat (misalnya, iPhone, Android)
        $platform = $agent->platform(); // Nama OS (misalnya, Windows, iOS)
        $browser = $agent->browser(); // Nama browser (misalnya, Chrome, Safari)

        Visitor::create([
            'ip_address' => $ip_address,
            'visit_time' => $visit_time,
            'session_id' => $session_id,
            'user_agent' => $user_agent,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
        ]);

        // Data lainnya yang diperlukan untuk tampilan
        $galeri = Galeri::all();
        $slider = Slider::all();
        $alasan = Alasan::all();
        $berita = Berita::with('kategoriBerita')->orderBy('id', 'desc')->paginate(1); // Gunakan paginate di sini
        return view('front.home', compact('slider', 'title', 'subtitle', 'berita', 'alasan'));
    }

    public function hitung_gizi()
    {
        $title = "Halaman Kalkulator Gizi";
        $subtitle = "Menu Kalkulator Gizi";


        return view('front.hitung_gizi', compact('title', 'subtitle'));
    }


    public function info()
    {
        $title = "Halaman Info";
        $subtitle = "Menu Info";
        return view('front.info', compact('title', 'subtitle'));
    }

    public function kpsp()
    {
        $title = "Halaman KPSP";
        $subtitle = "Menu KPSP";

        // Cek jika ada parameter success dan terakhir disimpan
        $hasil = null;
        if (session('success')) {
            $hasil = HasilKpsp::latest()->first(); // Ambil data terakhir
            if ($hasil) {
                $jawaban = json_decode($hasil->jawaban, true);
                $pertanyaan = Kpsp::where('umur', $hasil->umur)->get();
                return view('front.kpsp', compact('title', 'subtitle', 'hasil', 'jawaban', 'pertanyaan'));
            }
        }

        return view('front.kpsp', compact('title', 'subtitle', 'hasil'));
    }

    public function getKuesionerByUmur(Request $request)
    {
        $umur = $request->umur; // Umur dari request
        $kuesioner = Kpsp::where('umur', $umur)->get(); // Ambil data sesuai umur
        return response()->json($kuesioner); // Kembalikan dalam format JSON
    }

    public function hasil_kpsp(Request $request)
    {
        try {
            // Log data yang masuk
            \Log::info('KPSP Form Data:', $request->all());

            // Decode jawaban JSON menjadi array
            $jawaban = json_decode($request->jawaban, true);

            // Validasi
            $validated = $request->validate([
                'nama' => 'required|string',
                'nama_ortu' => 'required|string',
                'no_wa' => 'required',
                'tanggal_lahir' => 'required|date',
                'umur' => 'required|integer',
                'jenis_kelamin' => 'required|string',
                'wilayah_puskesmas' => 'nullable|string',
            ]);

            // Hitung total jawaban "Ya"
            $totalYa = collect($jawaban)->filter(fn($value) => $value === 'Ya')->count();

            // Tentukan interpretasi
            $interpretasi = '';
            if ($totalYa >= 9) {
                $interpretasi = "SESUAI UMUR";
            } elseif ($totalYa >= 7) {
                $interpretasi = "MERAGUKAN";
            } else {
                $interpretasi = "ADA KEMUNGKINAN PENYIMPANGAN";
            }

            // Simpan data
            $hasilKpsp = HasilKpsp::create([
                'nama_ortu' => $request->nama_ortu,
                'no_wa' => $request->no_wa,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'umur' => $request->umur,
                'jenis_kelamin' => $request->jenis_kelamin,
                'wilayah_puskesmas' => $request->wilayah_puskesmas,
                'total_ya' => $totalYa,
                'interpretasi' => $interpretasi,
                'jawaban' => $request->jawaban, // Simpan dalam format JSON string
            ]);

            // Ubah redirect ke halaman hasil
            if ($hasilKpsp) {
                return redirect()->route('show.hasil_kpsp', $hasilKpsp->id)->with('success', 'Hasil KPSP berhasil disimpan');
            }
        } catch (\Exception $e) {
            \Log::error('Error saving KPSP result: ' . $e->getMessage());
            return redirect('/kpsp')->with('error', 'Gagal menyimpan hasil KPSP: ' . $e->getMessage());
        }
    }

    // public function hasil_kpsp(Request $request)
    // {
    //     try {
    //         \Log::info('KPSP Form Data:', $request->all());

    //         $jawaban = json_decode($request->jawaban, true);
    //         // Validasi
    //         $validated = $request->validate([
    //             'nama' => 'required|string',
    //             'nama_ortu' => 'required|string',
    //             'no_wa' => 'required',
    //             'tanggal_lahir' => 'required|date',
    //             'umur' => 'required|integer',
    //             'jenis_kelamin' => 'required|string',
    //             'wilayah_puskesmas' => 'nullable|string',
    //         ]);

    //         // Hitung total jawaban "Ya"
    //         $totalYa = collect($jawaban)->filter(fn($value) => $value === 'Ya')->count();

    //         // Tentukan interpretasi
    //         $interpretasi = '';
    //         if ($totalYa >= 9) {
    //             $interpretasi = "SESUAI UMUR";
    //         } elseif ($totalYa >= 7) {
    //             $interpretasi = "MERAGUKAN";
    //         } else {
    //             $interpretasi = "ADA KEMUNGKINAN PENYIMPANGAN";
    //         }

    //         // Simpan data
    //         $hasilKpsp = HasilKpsp::create([
    //             'nama_ortu' => $request->nama_ortu,
    //             'no_wa' => $request->no_wa,
    //             'nama' => $request->nama,
    //             'tanggal_lahir' => $request->tanggal_lahir,
    //             'umur' => $request->umur,
    //             'jenis_kelamin' => $request->jenis_kelamin,
    //             'wilayah_puskesmas' => $request->wilayah_puskesmas,
    //             'total_ya' => $totalYa,
    //             'interpretasi' => $interpretasi,
    //             'jawaban' => $request->jawaban, // Simpan dalam format JSON string
    //         ]);

    //         // Ubah redirect ke halaman hasil
    //         if ($hasilKpsp) {
    //             return redirect()->route('show.hasil_kpsp', $hasilKpsp->id)->with('success', 'Hasil KPSP berhasil disimpan');
    //         }
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal menyimpan hasil KPSP: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function show_hasil_kpsp($id)
    {
        $title = "Hasil KPSP";
        $subtitle = "Detail Hasil KPSP";

        $hasil = HasilKpsp::findOrFail($id);
        $jawaban = json_decode($hasil->jawaban, true);

        // Ambil pertanyaan sesuai umur
        $pertanyaan = Kpsp::where('umur', $hasil->umur)->get();

        return view('front.kpsp', compact('title', 'subtitle', 'hasil', 'jawaban', 'pertanyaan'));
    }



    public function sras()
    {
        $title = "Halaman Skrining Resiko Anemia & Stunting";
        $subtitle = "Menu Skrining Resiko Anemia & Stunting";
        return view('front.sras', compact('title', 'subtitle'));
    }

    public function hasil_sras(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'lila' => 'required|string|max:255',
            'berat_badan' => 'required|string|max:255',
            'tinggi_badan' => 'required|string|max:255',
            'hb' => 'required|string|max:255',
            'total_summary' => 'required|numeric',
            'hasil' => 'required|string',
            'deskripsi' => 'required|json',
        ]);

        // Simpan ke database
        $hasil = new \App\Models\HasilSras();
        $hasil->nama = $validatedData['nama'];
        $hasil->tanggal_lahir = $validatedData['tanggal_lahir'];
        $hasil->umur = $validatedData['umur'];
        $hasil->jenis_kelamin = $validatedData['jenis_kelamin'];
        $hasil->lila = $validatedData['lila'];
        $hasil->berat_badan = $validatedData['berat_badan'];
        $hasil->tinggi_badan = $validatedData['tinggi_badan'];
        $hasil->hb = $validatedData['hb'];
        $hasil->total = $validatedData['total_summary'];
        $hasil->hasil = $validatedData['hasil'];
        $hasil->deskripsi = $validatedData['deskripsi'];

        $hasil->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }





    public function edunika()
    {
        $title = "Halaman Edunika";
        $subtitle = "Menu Edunika";


        $berita = Berita::with('kategoriBerita')->orderBy('id', 'desc')->paginate(4); // Gunakan paginate di sini



        return view('front.edunika', compact('title', 'subtitle', 'berita'));
    }

    public function edunika_detail($slug)
    {
        $title = "Halaman Edunika Detail";
        $subtitle = "Menu Edunika Detail";
        $berita = Berita::where('slug', $slug)->firstOrFail();

        return view('front.edunika_detail', compact('berita', 'title', 'subtitle'));
    }

    public function video()
    {
        $title = "Halaman Feeding Screen";
        $subtitle = "Menu Feeding Screen";

        // Mengurutkan video berdasarkan field 'urutan'
        $video = Video::orderBy('urutan', 'asc')->paginate(2);

        return view('front.video', compact('title', 'subtitle', 'video'));
    }


    public function galeri_pengguna()
    {
        $title = "Halaman Galeri";
        $subtitle = "Menu Galeri";

        $galeri = Galeri::paginate(4);



        return view('front.galeri_pengguna', compact('title', 'subtitle', 'galeri'));
    }
}
