<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_type_id' => \App\Models\TransactionType::all()->random()->id,
            'account_id' =>  \App\Models\Account::all()->random()->id,
            'value' => fake()->unique()->randomNumber(7, false),
        ];
    }
}
