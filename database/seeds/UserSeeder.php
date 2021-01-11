<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'email' => 'dhana@coba.com',
            'name' => 'Anargya Dhana',
            'password' => Hash::make("dhana123")
        ]);
    }
}
