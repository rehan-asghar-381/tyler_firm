<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'roles-create', 'description'=>'User can create roles.']);
        Permission::create(['name' => 'roles-edit', 'description'=>'User can edit roles.']);
        Permission::create(['name' => 'roles-delete', 'description'=>'User can delete roles.']);
        Permission::create(['name' => 'roles-list', 'description'=>'User can view roles listing.']);

        Permission::create(['name' => 'users-create', 'description'=>'User can create new user.']);
        Permission::create(['name' => 'users-edit', 'description'=>'User can edit user.']);
        Permission::create(['name' => 'users-delete', 'description'=>'User can delete user.']);
        Permission::create(['name' => 'users-list', 'description'=>'User can view user listing.']);

        Permission::create(['name' => 'orders-create', 'description'=>'User can create order.']);
        Permission::create(['name' => 'orders-list', 'description'=>'User can view order.']);

        // create roles and assign existing permissions

        $role3 = Role::create(['name' => 'Super Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole($role3);
    }
}