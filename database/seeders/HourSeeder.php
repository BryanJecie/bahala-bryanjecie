<?php

namespace Database\Seeders;

use App\Domains\Dashboard\Models\StoreHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hours = [
            ['day' => 'monday', 'open_time' => '08:00', 'close_time' => '16:00', 'lunch_start' => '12:00', 'lunch_end' => '12:45'],
            ['day' => 'wednesday', 'open_time' => '08:00', 'close_time' => '16:00', 'lunch_start' => '12:00', 'lunch_end' => '12:45'],
            ['day' => 'friday', 'open_time' => '08:00', 'close_time' => '16:00', 'lunch_start' => '12:00', 'lunch_end' => '12:45'],
        ];

        foreach ($hours as $hour) {
            StoreHour::updateOrCreate(['day' => $hour['day']], $hour);
        }
    }
}
