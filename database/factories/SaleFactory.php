<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 100, 10000);
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.2);

        return [
            'tenant_id' => Tenant::factory(),
            'branch_id' => Branch::factory(),
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'reference' => 'INV-'.strtoupper(Str::random(8)),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'payment_method' => fake()->randomElement(['cash', 'card', 'transfer']),
            'status' => 'completed',
        ];
    }
}