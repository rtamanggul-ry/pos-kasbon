<?php

namespace App\Models;

use Database\Factories\PelangganFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_pelanggan', 'no_hp'])]
class Pelanggan extends Model
{
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }

    public function kasbons(): HasMany
    {
        return $this->hasMany(Kasbon::class, 'id_pelanggan');
    }

    /** @use HasFactory<PelangganFactory> */
    use HasFactory;
}
