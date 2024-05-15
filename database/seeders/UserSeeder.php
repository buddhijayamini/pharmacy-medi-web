<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = User::create(
            [
                'name' => 'pharmacy',
                'email' => 'admin@gmail.com',
                'role_id' => 1,
                'password' => 'admin@1234',
                'status' => 1
            ]
        );
    }
}
