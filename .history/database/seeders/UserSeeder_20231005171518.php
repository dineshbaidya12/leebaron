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
        $user1 = [
            'first_name' => 'SK',
            'last_name' => 'Sumit',
            'name' => 'Sumit',
            'profile_picture' => 'Me.jpg',
            'role' => 'admin',
            'email' => 'sumit@gmail.com',
            'password' => Hash::make('Sumit'),
            'plain_pass' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        $user2 = [
            'first_name' => 'Coder',
            'last_name' => 'Web',
            'name' => 'CoderWeb',
            'profile_picture' => 'Coder_1_profile_picture_651e4bae761e8.jpg',
            'role' => 'admin',
            'email' => 'coder.web@gmail.com',
            'password' => Hash::make('admin'),
            'plain_pass' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        // Insert or skip if email already exists
        User::firstOrCreate(['email' => $user1['email']], $user1);
        User::firstOrCreate(['email' => $user2['email']], $user2);
    }
    
}
