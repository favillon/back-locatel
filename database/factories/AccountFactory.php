<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_number' => fake()->uuid(),
            'user_id' =>  \App\Models\User::all()->random()->id,
            'account_type_id' => \App\Models\AccountType::all()->random()->id,
            'balance' => 0
        ];
    }
}
