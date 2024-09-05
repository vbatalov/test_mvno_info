<?php

namespace Database\Seeders;

use App\Models\Sim;
use App\Models\Subscriber;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $f_subscriber = Subscriber::create([
            "group_id" => 1,
            "min_balance" => -50,
        ]);
        $f_sim = Sim::create([
            "iccid" => 1234567890,
            "subscriber_id" => $f_subscriber->id,
        ]);

        $s_subscriber = Subscriber::create([
            "group_id" => 1
        ]);
        $s_sim = Sim::create([
            "iccid" => 10987654321,
            "subscriber_id" => $s_subscriber->id,
        ]);
    }
}
