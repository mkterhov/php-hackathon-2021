<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Type;
use App\Models\User;
use App\Models\Programme;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProgrammeTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *
     * @return void
     */
    /** @test */
    public function test_store_programme_test_no_validations()
    {

        $user = User::factory()->create();

        Room::factory(20)->create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);

        $faker = Faker::create();

        $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+1 month')->getTimestamp());

        $data = [
            'user_id' => 1,
            'title' => "test title",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 12,
            'capacity'=> 50,
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
        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);
        $faker = Faker::create();
        User::factory(20)->create();
        Room::factory(20)->create();

        foreach (range(1, 15) as $index) {
            $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('now', '+1 month')->getTimestamp());


            Programme::factory()->create([
                'user_id' => $faker->numberBetween(1, 20),
                'type_id' => $faker->numberBetween(1, 2),
                'title' => ucwords($faker->words(2, true)),
                'room_id' => $faker->numberBetween(1, 20),
                'capacity' => $faker->numberBetween(20, 100),
                'start_time' => $startDate->toDateTimeString(),
                'end_time'   => $startDate->addHours( $faker->numberBetween( 1, 3 ) )
            ]);

        }
        $response = $this->get('/api/programmes');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_delete_programme()
    {
        $user = User::factory()->create();

        Room::factory(1)->create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);

        $faker = Faker::create();

        Programme::factory()->create([
            'user_id' => 1,
            'title' => "TESTS TESTS TESTS",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 1,
            'capacity'=> 5,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ]);
        Programme::factory()->create([
            'user_id' => 1,
            'title' => "NEW TEST",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 1,
            'capacity'=> 5,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ]);
        $response = $this->delete('/api/programmes/',["programme_id" => 1]);
        $this->assertDatabaseHas('programmes',[
            'title' => 'TESTS TESTS TESTS',
        ]);
    }
}
