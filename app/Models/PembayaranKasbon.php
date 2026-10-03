<?php

namespace App\Models;

use Database\Factories\PembayaranKasbonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_kasbon', 'tanggal_bayar', 'nominal_bayar'])]
class PembayaranKasbon extends Model
{
    public function kasbon(): BelongsTo
    {
        return $this->belongsTo(Kasbon::class, 'id_kasbon');
    }

    /** @use HasFactory<PembayaranKasbonFactory> */
    use HasFactory;
}
