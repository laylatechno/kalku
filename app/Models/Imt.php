<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imt extends Model
{
    use HasFactory;

    protected $table = 'imt'; // tentukan nama tabel secara eksplisit
    protected $guarded = [];
 
}
