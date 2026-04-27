<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@ums.ac.id'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN,
            ]
        );
        User::updateOrCreate(
            ['email' => 'kasir@ums.ac.id'],
            [
                'name' => 'Kasir Abdul',
                'password' => bcrypt('password'),
                'role' => User::ROLE_KASIR,
            ]
        );
        User::updateOrCreate(
            ['email' => 'finance@ums.ac.id'],
            [
                'name' => 'Finance',
                'password' => bcrypt('password'),
                'role' => User::ROLE_FINANCE,
            ]
        );
    }
}
