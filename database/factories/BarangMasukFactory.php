<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarangMasuk>
 */
class BarangMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_barang' => Barang::factory(),
            'tanggal_masuk' => fake()->date(),
            'jumlah_masuk' => fake()->numberBetween(10, 100),
        ];
    }
}
