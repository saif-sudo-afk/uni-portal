<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfessorUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'professor@example.com'],
            [
                'name' => 'Default Professor',
                'password' => Hash::make('password'),
                'role' => 'professor',
            ]
        );
    }
}
