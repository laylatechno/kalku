<?php
namespace App\Imports;

use App\Models\Imt;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImtImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Row Data:', $row);
        return new Imt([
            'umur' => $row['umur'],
            'status' => $row['status'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'min_3_sd' => $row['min_3_sd'],
            'min_2_sd' => $row['min_2_sd'],
            'min_1_sd' => $row['min_1_sd'],
            'median' => $row['median'],
            'max_1_sd' => $row['max_1_sd'],
            'max_2_sd' => $row['max_2_sd'],
            'max_3_sd' => $row['max_3_sd'],
            'urutan' => $row['urutan'],
        ]);
    }
}

