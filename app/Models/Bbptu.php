<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bbptu extends Model
{
    use HasFactory;

    protected $table = 'bbpt_u'; // tentukan nama tabel secara eksplisit
    protected $guarded = [];
 
}
