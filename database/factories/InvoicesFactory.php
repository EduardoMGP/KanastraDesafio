<?php

namespace Database\Factories;

use App\Models\Invoices;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoices>
 */
class InvoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'debtId' => $this->faker->unique()->randomNumber(),
            'name' => $this->faker->name(),
            'governmentId' => $this->faker->randomNumber(),
            'email' => $this->faker->email(),
            'debtAmount' => $this->faker->randomFloat(2, 0, 1000),
            'debtDueDate' => $this->faker->date(),
        ];
    }
}
