<?php

namespace Database\Factories;

use App\Models\Kasbon;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kasbon>
 */
class KasbonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pelanggan' => Pelanggan::factory(),
            'id_transaksi' => Transaksi::factory(),
            'total_utang' => fake()->numberBetween(10000, 500000),
            'sisa_tagihan' => fake()->numberBetween(0, 500000),
            'status' => fake()->randomElement(['Lunas', 'Belum Lunas']),
        ];
    }
}
