<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission; // Ensure Permission model is imported
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate(); // Clear existing permissions
        // Assets
        Permission::create(['name' => 'view_assets', 'description' => 'View assets']);
        Permission::create(['name' => 'create_assets', 'description' => 'Create assets']);
        Permission::create(['name' => 'edit_assets', 'description' => 'Edit assets']);
        Permission::create(['name' => 'delete_assets', 'description' => 'Delete assets']);
        Permission::create(['name' => 'assign_assets', 'description' => 'Assign assets to users']);
        // Purchases
        Permission::create(['name' => 'view_purchases', 'description' => 'View purchases']);
        Permission::create(['name' => 'create_purchases', 'description' => 'Create purchases']);
        Permission::create(['name' => 'edit_purchases', 'description' => 'Edit purchases']);
        Permission::create(['name' => 'delete_purchases', 'description' => 'Delete purchases']);
        // SoftwareLicenses
        Permission::create(['name' => 'view_software_licenses', 'description' => 'View software licenses']);
        Permission::create(['name' => 'create_software_licenses', 'description' => 'Create software licenses']);
        Permission::create(['name' => 'edit_software_licenses', 'description' => 'Edit software licenses']);
        Permission::create(['name' => 'delete_software_licenses', 'description' => 'Delete software licenses']);
        // Vendors
        Permission::create(['name' => 'view_vendors', 'description' => 'View vendors']);
        Permission::create(['name' => 'create_vendors', 'description' => 'Create vendors']);
        Permission::create(['name' => 'edit_vendors', 'description' => 'Edit vendors']);
        Permission::create(['name' => 'delete_vendors', 'description' => 'Delete vendors']);
        // User Management (example)
        Permission::create(['name' => 'manage_users', 'description' => 'Manage users and roles']);
    }
}
