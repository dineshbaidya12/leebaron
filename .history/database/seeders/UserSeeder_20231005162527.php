<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'SK',
            'last_name' => 'Sumit',
            'name' => 'Sumit',
            'role' => 'admin',
            'email' => 'webgrity@gmail.com',
            'password' => Hash::make('Sumit'),
        ]);
    }
}
