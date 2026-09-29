<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_barang' => fake()->word(),
            'harga_modal' => fake()->numberBetween(1000, 50000),
            'harga_jual' => fake()->numberBetween(55000, 100000),
            'stok' => fake()->numberBetween(0, 100),
        ];
    }
}
