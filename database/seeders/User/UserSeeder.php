<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->create([
                'email'    => 'test1@exmaple.com',
                'password' => Hash::make('password'),
            ]);

        User::factory()
            ->create([
                'email'    => 'test2@exmaple.com',
                'password' => Hash::make('password'),
            ]);

        User::factory()
            ->create([
                'email'    => 'test3@exmaple.com',
                'password' => Hash::make('password'),
            ]);
    }
}
