<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'name'      => 'Admin PLN',
            'email'     => 'admin@gmail.com',
            'roles'     => "ADMIN",
            'password'  => bcrypt('password')
        ]);

        User::create([
            'name'      => 'Admin RUmah BUMN',
            'email'     => 'rb@gmail.com',
            'roles'     => "RB",
            'password'  => bcrypt('password')
        ]);
    }
}
