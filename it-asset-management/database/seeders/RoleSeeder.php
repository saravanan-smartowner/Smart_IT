<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Ensure Role model is imported
use Illuminate\Support\Facades\DB; // For direct DB operations if needed

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate(); // Clear existing roles to avoid conflicts if re-seeding
        Role::create(['name' => 'Admin', 'description' => 'Administrator with full access']);
        Role::create(['name' => 'IT Manager', 'description' => 'Manages IT assets and operations']);
        Role::create(['name' => 'Auditor', 'description' => 'Can view records and logs']);
        Role::create(['name' => 'General Staff', 'description' => 'General user with limited access']);
    }
}
