<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'=>'Super Admin',
            'email'=>'super_admin@gmail.com',
            'password'=>bcrypt('32bit.PNG'),
            'status'=>'active',
            'role'=>1
        ]);
        App\User::create([
            'name'=>'Test Admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('32bit.PNG'),
            'status'=>'active',
            'role'=>2
        ]);
        App\User::create([
            'name'=>'Test User',
            'email'=>'user@gmail.com',
            'password'=>bcrypt('32bit.PNG'),
            'status'=>'active',
            'role'=>3
        ]);
        App\User::create([
            'name'=>'Guest',
            'email'=>'guest@gmail.com',
            'password'=>bcrypt('32bit.PNG'),
            'status'=>'active',
            'role'=>4
        ]);
    }
}
