<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Sk',
            'last_name' => 'Sumit',
            'name' => 'Sumit',
            'email' => 'webgrity@gmail.com',
            'password' => Hash::make('Sumit'),
        ]);
    }
}
