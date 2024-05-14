<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'pharmacy', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Create permissions
        Permission::create(['name' => 'create-post', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-post', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-post', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-post', 'guard_name' => 'web']);

        // Assign permissions to the admin role
        $adminRole->syncPermissions(['create-post', 'edit-post', 'view-post', 'delete-post']);
    }
}
