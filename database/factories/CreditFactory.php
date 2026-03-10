<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credit>
 */
class CreditFactory extends Factory
{
    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 100, 5000);
        $amountPaid = fake()->randomFloat(2, 0, $amount);

        return [
            'tenant_id' => Tenant::factory(),
            'branch_id' => Branch::factory(),
            'customer_id' => Customer::factory(),
            'sale_id' => Sale::factory(),
            'amount' => $amount,
            'amount_paid' => $amountPaid,
            'balance' => $amount - $amountPaid,
            'due_date' => fake()->dateTimeBetween('now', '+3 months'),
            'status' => fake()->randomElement(['unpaid', 'partial', 'paid']),
        ];
    }

    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'amount_paid' => 0,
            'balance' => $attributes['amount'],
            'status' => 'unpaid',
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'amount_paid' => $attributes['amount'],
            'balance' => 0,
            'status' => 'paid',
        ]);
    }
}