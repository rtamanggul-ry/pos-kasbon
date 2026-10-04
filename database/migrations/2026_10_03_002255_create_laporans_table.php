<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_laporan')->unique();
            $table->integer('total_pendapatan_tunai')->default(0);
            $table->integer('total_kasbon_baru')->default(0);
            $table->integer('total_pembayaran_kasbon')->default(0);
            $table->integer('total_pengeluaran_restok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
