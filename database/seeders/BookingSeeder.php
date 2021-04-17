<?php

namespace Database\Seeders;

use App\Models\Booking;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
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


            Booking::factory()->create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'programme_id' => $faker->numberBetween(1, 15),
                'cnp' => $faker->regexify('[0-9]{13}'),
            ]);
        }
    }
}
