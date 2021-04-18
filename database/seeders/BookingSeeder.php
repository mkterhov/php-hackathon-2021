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

        foreach (range(1, 15) as $i) {
            Booking::factory()->create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'programme_id' =>  $i,
                'cnp' => $faker->regexify('[0-9]{13}'),
            ]);
        }
    }
}
