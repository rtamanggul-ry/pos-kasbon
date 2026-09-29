<?php

namespace App\Models;

use Database\Factories\PelangganFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_pelanggan', 'no_hp'])]
class Pelanggan extends Model
{
    /** @use HasFactory<PelangganFactory> */
    use HasFactory;
}
