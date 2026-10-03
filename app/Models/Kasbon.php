<?php

namespace App\Models;

use Database\Factories\KasbonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id_pelanggan', 'id_transaksi', 'total_utang', 'sisa_tagihan', 'status'])]
class Kasbon extends Model
{
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function pembayaranKasbons(): HasMany
    {
        return $this->hasMany(PembayaranKasbon::class, 'id_kasbon');
    }

    /** @use HasFactory<KasbonFactory> */
    use HasFactory;
}
