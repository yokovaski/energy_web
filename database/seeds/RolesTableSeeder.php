<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Models\Role::create([
            'name' => 'admin',
        ]);

        $role->save();

        $role = \App\Models\Role::create([
            'name' => 'client',
        ]);

        $role->save();
    }
}
