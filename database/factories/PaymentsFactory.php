<?php

namespace Database\Factories;

use App\Models\Invoices;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'debtId'     => $this->faker->randomNumber(),
            'paidAt'     => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'paidAmount' => $this->faker->randomFloat(2, 0, 1000),
            'paidBy'     => $this->faker->name(),
        ];
    }
}
