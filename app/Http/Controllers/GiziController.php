<?php

namespace App\Http\Controllers;

use App\Models\Bbptu;
use Illuminate\Http\Request;


use App\Models\Bbu;
use App\Models\HasilHitung;
use App\Models\Imt;
use App\Models\Ptbu;
use Illuminate\Support\Facades\Log;



class GiziController extends Controller
{

    public function determineStatus(Request $request)
    {
        $title = "Halaman Gizi";
        $subtitle = "Menu Gizi";

        Log::info('Request received', $request->all());

        // Define custom validation messages
        $messages = [
            'nama.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            'umur.required' => 'Umur harus diisi.',
            'umur.integer' => 'Umur harus berupa angka.',
            'berat_badan.required' => 'Berat badan harus diisi.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'tinggi_badan.required' => 'Tinggi badan harus diisi.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus salah satu dari: Laki-laki atau Perempuan.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.'
        ];

        $data = $request->validate([
            'nama' => 'nullable|string|max:100',
            'nama_ortu' => 'nullable|string|max:100',
            'no_wa' => 'nullable|string|max:100',
            'wilayah_kerja_puskesmas' => 'nullable|string|max:100',
            'umur' => 'required|integer',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'date'
        ], $messages);


        // Set default value for 'nama' if not provided
        $data['nama'] = $data['nama'] ?? 'Fulan';

        Log::info('Validated data', $data);

        // Fetch reference data for weight and height
        $bbuReference = Bbu::where('jenis_kelamin', $data['jenis_kelamin'])
            ->where('umur', $data['umur'])  // Assuming you have a column for age range or similar in your Bbu table
            ->first();

        $ptbReference = Ptbu::where('jenis_kelamin', $data['jenis_kelamin'])
            ->where('umur', $data['umur'])  // Assuming you have a column for age range or similar in your Bbu table
            ->first();

        // // Determine which status to search for in Bbptu table based on age
        $statusToSearch = ($data['umur'] < 24) ? 'PB' : 'TB';

        // // Log statusToSearch, jenis_kelamin, and tinggi_badan for debugging
        Log::info('Status to search', ['statusToSearch' => $statusToSearch, 'jenis_kelamin' => $data['jenis_kelamin'], 'tinggi_badan' => $data['tinggi_badan']]);

        // // Fetch BBPTU data with conditions on status, jenis_kelamin, and tinggi_badan
        // $bbptuData = Bbptu::where('status', $statusToSearch)
        //     ->where('jenis_kelamin', $data['jenis_kelamin'])
        //     ->where('tinggi_badan', '<=', $data['tinggi_badan'])
        //     ->first();


        $bbptuData = Bbptu::where('status', $statusToSearch)
            ->where('jenis_kelamin', $data['jenis_kelamin'])
            ->where('tinggi_badan', '<=', $data['tinggi_badan'])
            ->orderBy('tinggi_badan', 'desc')  // Mengurutkan dari yang terbesar
            ->first();  // Mengambil yang paling mendekati

        // Initialize status variables
        $weightStatus = 'Tidak Diketahui';
        $heightStatus = 'Tidak Diketahui';
        $bbptuStatus = 'Tidak Diketahui';

        // Check if any of the references are missing
        $error = false;
        $errorMessage = '';

        if (!$bbuReference) {
            Log::error('Bbu reference data not found', ['jenis_kelamin' => $data['jenis_kelamin']]);
            $errorMessage .= ' Data referensi Bbu tidak ditemukan.';
            $error = true;
        }

        if (!$ptbReference) {
            Log::error('Ptb reference data not found', ['jenis_kelamin' => $data['jenis_kelamin']]);
            $errorMessage .= ' Data referensi Ptb tidak ditemukan.';
            $error = true;
        }

        if (!$bbptuData) {
            Log::error('BBPTU data not found', ['status' => $statusToSearch, 'jenis_kelamin' => $data['jenis_kelamin'], 'tinggi_badan' => $data['tinggi_badan']]);
            $errorMessage .= ' Data BBPTU tidak ditemukan.';
            $error = true;
        }

        // Fetch IMT reference data based on age and gender
        // $imtStatus = ($data['umur'] <= 60) ? 'Bawah' : 'Atas';
        // $imtReference = Imt::where('status', $imtStatus)
        $imtReference = Imt::where('umur', $data['umur'])
            ->where('jenis_kelamin', $data['jenis_kelamin'])
            ->first();

        if (!$imtReference) {
            Log::error('IMT reference data not found', ['umur' => $data['umur'], 'jenis_kelamin' => $data['jenis_kelamin']]);
            $errorMessage .= ' Data referensi IMT tidak ditemukan.';
            $error = true;
        }

        if ($error) {
            // Return view with error message
            return view('front.hitung_gizi', compact('title', 'subtitle', 'errorMessage'));
        }

        // Calculate weight status based on Bbu standards
        $berat_badan = $data['berat_badan'];

        if ($berat_badan < $bbuReference->min_3_sd) {
            $weightStatus = 'Berat Badan Sangat Kurang';
        } elseif ($berat_badan >= $bbuReference->min_3_sd && $berat_badan < $bbuReference->min_2_sd) {
            $weightStatus = 'Berat Badan Kurang';
        } elseif ($berat_badan >= $bbuReference->min_2_sd && $berat_badan <= $bbuReference->max_1_sd) {
            $weightStatus = 'Berat Badan Normal';
        } elseif ($berat_badan > $bbuReference->max_1_sd) {
            $weightStatus = 'Berat Badan Lebih';
        }
        Log::info('Calculated weight status', ['weightStatus' => $weightStatus]);

        // // Calculate height status based on Ptbu standards
        $tinggi_badan = $data['tinggi_badan'];

        if ($tinggi_badan < $ptbReference->min_3_sd) {
            $heightStatus = 'Sangat Pendek';
        } elseif ($tinggi_badan >= $ptbReference->min_3_sd && $tinggi_badan < $ptbReference->min_2_sd) {
            $heightStatus = 'Pendek';
        } elseif ($tinggi_badan >= $ptbReference->min_2_sd && $tinggi_badan < $ptbReference->max_3_sd) {
            $heightStatus = 'Normal';
        } else {
            $heightStatus = 'Tinggi';
        }

        Log::info('Calculated height status', ['heightStatus' => $heightStatus]);


        // dd([
        //     'berat_badan' => $berat_badan,
        //     'status' => $statusToSearch,
        //     'bbptuData' => [
        //         'status' => $bbptuData->status,
        //         'jenis_kelamin' => $bbptuData->jenis_kelamin,
        //         'tinggi_badan' => $bbptuData->tinggi_badan,
        //         'min_3_sd' => $bbptuData->min_3_sd,
        //         'min_2_sd' => $bbptuData->min_2_sd,
        //         'max_1_sd' => $bbptuData->max_1_sd,
        //         'max_2_sd' => $bbptuData->max_2_sd,
        //         'max_3_sd' => $bbptuData->max_3_sd
        //     ]
        // ]);

        // Kode if condition setelahnya...
        // Calculate weight status based on BBPTU standards
        if ($berat_badan < $bbptuData->min_3_sd) {
            $bbptuStatus = 'Gizi Buruk';
        } elseif ($berat_badan >= $bbptuData->min_3_sd && $berat_badan < $bbptuData->min_2_sd) {
            $bbptuStatus = 'Gizi Kurang';
        } elseif ($berat_badan >= $bbptuData->min_2_sd && $berat_badan <= $bbptuData->max_1_sd) {
            $bbptuStatus = 'Gizi Baik';
        } elseif ($berat_badan > $bbptuData->max_1_sd && $berat_badan <= $bbptuData->max_2_sd) {
            $bbptuStatus = 'Resiko Gizi Lebih';
        } elseif ($berat_badan > $bbptuData->max_2_sd && $berat_badan <= $bbptuData->max_3_sd) {
            $bbptuStatus = 'Gizi Lebih';
        } else {
            $bbptuStatus = 'Obesitas';
        }
        Log::info('Calculated BBPTU weight status', ['bbptuStatus' => $bbptuStatus]);

        // Convert height from cm to meters and calculate IMT
        $tinggi_badan_m = $tinggi_badan / 100;
        $imt = $berat_badan / ($tinggi_badan_m * $tinggi_badan_m);

        // Determine IMT status
        $imtStatusDescription = 'Tidak Diketahui';

        if ($imt < $imtReference->min_3_sd) {
            $imtStatusDescription = 'Gizi Buruk';
        } elseif ($imt >= $imtReference->min_3_sd && $imt < $imtReference->min_2_sd) {
            $imtStatusDescription = 'Gizi Kurang';
        } elseif ($imt >= $imtReference->min_2_sd && $imt <= $imtReference->max_1_sd) {
            $imtStatusDescription = 'Gizi Baik';
        } elseif ($imt > $imtReference->max_1_sd && $imt <= $imtReference->max_2_sd) {
            $imtStatusDescription = 'Beresiko Gizi Lebih';
        } elseif ($imt > $imtReference->max_2_sd && $imt <= $imtReference->max_3_sd) {
            $imtStatusDescription = 'Gizi Lebih';
        } else {
            $imtStatusDescription = 'Obesitas';
        }

        Log::info('Calculated IMT status', ['imtStatus' => $imtStatusDescription]);

        // Save results to hasil_hitung table
        HasilHitung::create([
            'nama' => $data['nama'],
            'nama_ortu' => $data['nama_ortu'],
            'no_wa' => $data['no_wa'],
            'wilayah_kerja_puskesmas' => $data['wilayah_kerja_puskesmas'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'umur' => $data['umur'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tinggi_badan' => $data['tinggi_badan'],
            'berat_badan' => $data['berat_badan'],
            'result_bb_u' => $weightStatus,
            'result_tb_u' => $heightStatus,
            'result_bb_tb' => $bbptuStatus,
            'result_imt' => $imtStatusDescription
        ]);

        return redirect()->route('hitung_gizi')->with([
            'title' => $title,
            'subtitle' => $subtitle,
            'nama' => $data['nama'],
            'nama_ortu' => $data['nama_ortu'],
            'no_wa' => $data['no_wa'],
            'wilayah_kerja_puskesmas' => $data['wilayah_kerja_puskesmas'],
            'umur' => $data['umur'],
            'berat_badan' => $data['berat_badan'],
            'tinggi_badan' => $data['tinggi_badan'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'weightStatus' => $weightStatus,
            'heightStatus' => $heightStatus,
            'bbptuStatus' => $bbptuStatus,
            'imtStatus' => $imtStatusDescription
        ]);
    }
    //     public function determineStatus(Request $request)
    // {
    //     $title = "Halaman Gizi";
    //     $subtitle = "Menu Gizi";

    //     Log::info('Request received', $request->all());

    //     // Define custom validation messages
    //     $messages = [
    //         'nama.max' => 'Nama tidak boleh lebih dari 100 karakter.',
    //         'umur.required' => 'Umur harus diisi.',
    //         'umur.integer' => 'Umur harus berupa angka.',
    //         'berat_badan.required' => 'Berat badan harus diisi.',
    //         'berat_badan.numeric' => 'Berat badan harus berupa angka.',
    //         'tinggi_badan.required' => 'Tinggi badan harus diisi.',
    //         'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
    //         'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
    //         'jenis_kelamin.in' => 'Jenis kelamin harus salah satu dari: Laki-laki atau Perempuan.',
    //         'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.'
    //     ];

    //     $data = $request->validate([
    //         'nama' => 'nullable|string|max:100',
    //         'umur' => 'required|integer',
    //         'berat_badan' => 'required|numeric',
    //         'tinggi_badan' => 'required|numeric',
    //         'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //         'tanggal_lahir' => 'date'
    //     ], $messages);

    //     // Set default value for 'nama' if not provided
    //     $data['nama'] = $data['nama'] ?? 'Fulan';

    //     Log::info('Validated data', $data);

    //     // Fetch reference data for weight and height based on gender and age
    //     $bbuReference = Bbu::where('jenis_kelamin', $data['jenis_kelamin'])
    //                         ->where('umur', $data['umur'])  // Assuming you have a column for age range or similar in your Bbu table
    //                         ->first();

    //     if (!$bbuReference) {
    //         Log::error('Bbu reference data not found', ['jenis_kelamin' => $data['jenis_kelamin'], 'umur' => $data['umur']]);
    //         $errorMessage = 'Data referensi Bbu tidak ditemukan.';
    //         return view('front.hitung_gizi', compact('title', 'subtitle', 'errorMessage'));
    //     }

    //     Log::info('Bbu reference data', ['bbuReference' => $bbuReference]);

    //     // Initialize status variable
    //     $weightStatus = 'Tidak Diketahui';

    //     // Calculate weight status based on Bbu standards
    //     $berat_badan = $data['berat_badan'];

    //     if ($berat_badan < $bbuReference->min_3_sd) {
    //         $weightStatus = 'Berat Badan Sangat Kurang';
    //     } elseif ($berat_badan >= $bbuReference->min_3_sd && $berat_badan < $bbuReference->min_2_sd) {
    //         $weightStatus = 'Berat Badan Kurang';
    //     } elseif ($berat_badan >= $bbuReference->min_2_sd && $berat_badan <= $bbuReference->max_1_sd) {
    //         $weightStatus = 'Berat Badan Normal';
    //     } elseif ($berat_badan > $bbuReference->max_1_sd) {
    //         $weightStatus = 'Berat Badan Lebih';
    //     }

    //     Log::info('Calculated weight status', ['weightStatus' => $weightStatus]);

    //     // Save results to hasil_hitung table
    //     HasilHitung::create([
    //         'nama' => $data['nama'],
    //         'tanggal_lahir' => $data['tanggal_lahir'],
    //         'umur' => $data['umur'],
    //         'jenis_kelamin' => $data['jenis_kelamin'],
    //         'tinggi_badan' => $data['tinggi_badan'],
    //         'berat_badan' => $data['berat_badan'],
    //         'result_bb_u' => $weightStatus,
    //     ]);

    //     return redirect()->route('hitung_gizi')->with([
    //         'title' => $title,
    //         'subtitle' => $subtitle,
    //         'nama' => $data['nama'],
    //         'umur' => $data['umur'],
    //         'berat_badan' => $data['berat_badan'],
    //         'tinggi_badan' => $data['tinggi_badan'],
    //         'jenis_kelamin' => $data['jenis_kelamin'],
    //         'weightStatus' => $weightStatus,
    //     ]);
    // }


}
