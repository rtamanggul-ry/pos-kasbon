<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DetailTransaksi>
 */
class DetailTransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_transaksi' => Transaksi::factory(),
            'id_barang' => Barang::factory(),
            'kuantitas' => fake()->numberBetween(1, 10),
            'harga_satuan' => fake()->numberBetween(1000, 50000),
            'sub_total' => fake()->numberBetween(1000, 100000),
        ];
    }
}
