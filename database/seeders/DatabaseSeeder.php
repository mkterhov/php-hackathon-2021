<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory(20)->create();
        Room::factory(20)->create();
        $this->call(ProgrammeSeeder::class);
        $this->call(BookingSeeder::class);
    }
}
