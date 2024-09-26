<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Ticket::create([
                'user_id' => 2,
                'subject' => $faker->sentence(5),
                'body' => $faker->paragraph(3),
                'status' => $faker->randomElement(['open', 'close']),
            ]);
        }
    }
}
