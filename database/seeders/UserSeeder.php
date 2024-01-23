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
        User::create([
            'nickname' => '즐망',
            'email' => 'akima9a@gmail.com',
            'password' => '1',
            'gender' => 'man',
            'age' => 34,
            'gym_id' => 1,
        ]);
    }
}
