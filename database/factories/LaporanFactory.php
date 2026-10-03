<?php

namespace Database\Factories;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Laporan>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal_laporan' => fake()->unique()->date(),
            'total_pendapatan_tunai' => fake()->numberBetween(0, 1000000),
            'total_kasbon_baru' => fake()->numberBetween(0, 500000),
            'total_pembayaran_kasbon' => fake()->numberBetween(0, 500000),
            'total_pengeluaran_restok' => fake()->numberBetween(0, 500000),
        ];
    }
}
