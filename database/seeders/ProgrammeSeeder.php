<?php

namespace Database\Seeders;

use App\Models\Type;
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
        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);
        foreach (range(1, 15) as $index) {
            $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+2 days')->getTimestamp());


            Programme::factory()->create([
                'user_id' => $faker->numberBetween(1, 20),
                'title' => ucwords($faker->words(2, true)),
                'type_id' => $faker->numberBetween(1, 2),
                'room_id' => $faker->numberBetween(1, 20),
                'capacity' => $faker->numberBetween(10, 15),
                'start_time' => $startDate->toDateTimeString(),
                'end_time'   => $startDate->addHours( $faker->numberBetween( 5, 10 ) )
            ]);
        }
    }
}
