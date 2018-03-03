<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // permissions
        $editUser = Permission::create(['name' => 'edit-user']);
        $deleteUser = Permission::create(['name' => 'delete-user']);

        // roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($editUser);
        $adminRole->givePermissionTo($deleteUser);

        $user = \App\Models\User::where('email', 'erwinlenting@outlook.com')->first();
        $user->assignRole($adminRole);
    }
}
