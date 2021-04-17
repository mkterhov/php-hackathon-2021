<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Programme;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgrammeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function test_store_programme_test_no_validations()
    {
        $user = User::factory()->create();
        Room::factory(20)->create();
        $faker = Faker::create();
        $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+1 month')->getTimestamp());
        $data = [
            'user_id' => 1,
            'title' => "test title",
            'room_id' => 12,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ];
        $response = $this->post('/api/programmes/',$data);

        $response->assertStatus(201);

    }

    /** @test */
    public function test_get_a_programme()
    {
        $faker = Faker::create();
        $response = $this->get('/api/programmes',["programme_id" => 2]);
        $response->assertStatus(200);


    }

    /** @test */
    public function test_index_programmes()
    {

        $faker = Faker::create();
        User::factory(20)->create();
        Room::factory(20)->create();

        foreach (range(1, 15) as $index) {
            $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+1 month')->getTimestamp());


            Programme::factory()->create([
                'user_id' => $faker->numberBetween(1, 20),
                'title' => ucwords($faker->words(2, true)),
                'room_id' => $faker->numberBetween(1, 20),
                'start_time' => $startDate->toDateTimeString(),
                'end_time'   => $startDate->addHours( $faker->numberBetween( 1, 3 ) )
            ]);
            $response = $this->get('/api/programmes');
            $response->assertStatus(200);

        }
    }
}
