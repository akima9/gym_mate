<?php

namespace Database\Seeders;

use App\Models\Gym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gym::create([
            'title' => '세인트짐',
            'address' => '서울특별시 송파구 송파동 19-2 지하1층',
        ]);
    }
}
