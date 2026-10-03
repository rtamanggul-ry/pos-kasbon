<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal' => fake()->date(),
            'total_harga' => fake()->numberBetween(10000, 500000),
            'metode_pembayaran' => fake()->randomElement(['Tunai', 'Kredit']),
            'id_pelanggan' => null,
        ];
    }
}
