<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptbu extends Model
{
    use HasFactory;

    protected $table = 'ptb_u'; // tentukan nama tabel secara eksplisit
    protected $guarded = [];
 
}
