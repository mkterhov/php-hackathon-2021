<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Type;
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
        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);
        User::factory(5)->create();
        Room::factory(5)->create();
        $this->call(ProgrammeSeeder::class);
        // $this->call(BookingSeeder::class);
    }
}
