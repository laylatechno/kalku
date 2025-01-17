<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bbu extends Model
{
    use HasFactory;

    protected $table = 'bb_u'; // tentukan nama tabel secara eksplisit
    protected $guarded = [];
 
}
