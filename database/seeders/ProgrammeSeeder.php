<?php

namespace Database\Seeders;

use App\Models\Programme;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 15) as $index) {
            $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+1 month')->getTimestamp());


            Programme::factory()->create([
                'user_id' => $faker->numberBetween(1, 20),
                'title' => ucwords($faker->words(2, true)),
                'room_id' => $faker->numberBetween(1, 20),
                'start_time' => $startDate->toDateTimeString(),
                'end_time'   => $startDate->addHours( $faker->numberBetween( 1, 3 ) )
            ]);
        }
    }
}
