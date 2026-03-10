<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditPayment>
 */
class CreditPaymentFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'credit_id' => Credit::factory(),
            'user_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 50, 1000),
            'payment_method' => fake()->randomElement(['cash', 'card', 'bank_transfer']),
            'notes' => fake()->optional()->sentence(),
            'paid_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
