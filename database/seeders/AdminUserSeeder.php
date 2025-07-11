<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ajitgurung04@gmail.com'],
            [
                'name' => 'ajitgurung',
                'password' => Hash::make('test1234'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
