<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'programme_id' => $faker->numberBetween(1, 15),
            'cnp' => $faker->regexify('[0-9]{13}'),
        ];
    }
}
