<?php

namespace Database\Factories;

use App\Models\Kasbon;
use App\Models\PembayaranKasbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PembayaranKasbon>
 */
class PembayaranKasbonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kasbon' => Kasbon::factory(),
            'tanggal_bayar' => fake()->date(),
            'nominal_bayar' => fake()->numberBetween(5000, 100000),
        ];
    }
}
