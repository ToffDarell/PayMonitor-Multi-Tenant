<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PlanSeeder::class);

        User::create([
            'tenant_id' => null,
            'branch_id' => null,
            'role' => 'superadmin',
            'name' => 'Super Admin',
            'email' => 'superadmin@paymonitor.com',
            'password' => Hash::make('password'),
        ]);

        $plan = Plan::where('name', 'Premium')->first();

        $tenant = Tenant::create([
            'plan_id' => $plan->id,
            'name' => 'Demo Company',
            'slug' => 'demo-company',
            'email' => 'info@democompany.com',
            'phone' => '0900-000-0001',
            'address' => '123 Demo Street, Demo City',
            'is_active' => true,
        ]);

        $mainBranch = Branch::create([
            'tenant_id' => $tenant->id,
            'name' => 'Main Branch',
            'address' => '123 Demo Street, Demo City',
            'phone' => '0900-000-0002',
            'is_active' => true,
        ]);

        Branch::create([
            'tenant_id' => $tenant->id,
            'name' => 'Second Branch',
            'address' => '456 Second Ave, Demo City',
            'phone' => '0900-000-0003',
            'is_active' => true,
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'branch_id' => $mainBranch->id,
            'role' => 'admin',
            'name' => 'Tenant Admin',
            'email' => 'admin@paymonitor.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'branch_id' => $mainBranch->id,
            'role' => 'manager',
            'name' => 'Branch Manager',
            'email' => 'manager@paymonitor.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'branch_id' => $mainBranch->id,
            'role' => 'staff',
            'name' => 'Cashier',
            'email' => 'cashier@paymonitor.com',
            'password' => Hash::make('password'),
        ]);

        Customer::factory(10)->create([
            'tenant_id' => $tenant->id,
            'branch_id' => $mainBranch->id,
        ]);

        Product::factory(20)->create([
            'tenant_id' => $tenant->id,
            'branch_id' => $mainBranch->id,
        ]);
    }
}
