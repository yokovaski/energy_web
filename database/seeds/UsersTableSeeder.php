<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Erwin Lenting',
            'email' => 'erwinlenting@outlook.com',
            'password' => bcrypt(env('ADMIN_USER_PASSWORD', 'password')),
        ]);

        $user->save();
    }
}
