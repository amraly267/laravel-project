<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //=== Create Super Admin User With A Full Role ===
        $user = \App\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'superadmin@yahoo.com',
            'password' => bcrypt('123456')
        ]);
        $user->attachRole('super_admin');
        //=== End Creation ===
    }
}
