<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing role_permissions for a clean slate
        DB::table('role_permissions')->truncate();

        // Define permissions for each role
        $adminPermissions = Permission::pluck('id', 'name');
        $itManagerPermissions = [
            'view_assets', 'create_assets', 'edit_assets', 'assign_assets', // No delete_assets for IT Manager
            'view_purchases', 'create_purchases', 'edit_purchases',
            'view_software_licenses', 'create_software_licenses', 'edit_software_licenses', 'delete_software_licenses',
            'view_vendors', 'create_vendors', 'edit_vendors',
        ];
        $auditorPermissions = ['view_assets', 'view_purchases', 'view_software_licenses', 'view_vendors'];
        $generalStaffPermissions = ['view_assets']; // Or specific assigned assets

        // Assign permissions
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync($adminPermissions->values()->all());
        }

        $itManagerRole = Role::where('name', 'IT Manager')->first();
        if ($itManagerRole) {
            $itManagerPermIds = Permission::whereIn('name', $itManagerPermissions)->pluck('id');
            $itManagerRole->permissions()->sync($itManagerPermIds);
        }

        $auditorRole = Role::where('name', 'Auditor')->first();
        if ($auditorRole) {
            $auditorPermIds = Permission::whereIn('name', $auditorPermissions)->pluck('id');
            $auditorRole->permissions()->sync($auditorPermIds);
        }

        $generalStaffRole = Role::where('name', 'General Staff')->first();
        if ($generalStaffRole) {
            $generalStaffPermIds = Permission::whereIn('name', $generalStaffPermissions)->pluck('id');
            $generalStaffRole->permissions()->sync($generalStaffPermIds);
        }
    }
}
