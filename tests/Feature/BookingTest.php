<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Type;
use App\Models\User;
use App\Models\Programme;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookingTest extends TestCase
{

    use DatabaseMigrations;
    /**
     *
     * @return void
     */
    /** @test */
    public function test_save_booking_to_a_programme()
    {
        $user = User::factory()->create();

        Room::factory(5)->create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);

        $faker = Faker::create();
        Programme::factory()->create([
            'user_id' => 1,
            'title' => "test title",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 2,
            'capacity'=> 10,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ]);
        $data = [
            'name' => 'JOHN SMITH',
            'email' => $faker->unique()->safeEmail,
            'programme_id' => 1,
            'cnp' => $faker->regexify('[0-9]{13}'),
        ];
        $response = $this->post('/api/bookings',$data);
        $response->assertStatus(200);
    }
    /**
     *
     * @return void
     */
    /** @test */
    public function test_save_booking_to_a_programme_that_overlaps()
    {
        $user = User::factory()->create();

        Room::factory(5)->create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);

        $faker = Faker::create();
        Programme::factory()->create([
            'user_id' => 1,
            'title' => "test title",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 2,
            'capacity'=> 10,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ]);
        $data = [
            'name' => 'JOHN SMITH',
            'email' => 'johnsmit@gmail.com',
            'programme_id' => 1,
            'cnp' => '1234567891234',
        ];
        $response = $this->post('/api/bookings',$data);
        $response->assertStatus(200);
    }
    /**
     *
     * @return void
     */
    /** @test */
    public function test_booking_validations_name()
    {

		Session::start();

        $user = User::factory()->create();

        Room::factory(5)->create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);

        $faker = Faker::create();
        Programme::factory()->create([
            'user_id' => 1,
            'title' => "test title",
            'type_id' => $faker->numberBetween(1, 2),
            'room_id' => 2,
            'capacity'=> 10,
            'start_time' => "2021-04-24 15:45:21",
            'end_time'   => "2021-04-24 17:45:21",
        ]);
        $data = [
            'name' => 123213,
            'email' => 'johnsmith@email.com',
            'programme_id' => 1,
            'cnp' =>  $faker->regexify('[0-9]{13}'),
        ];

        $response = $this->post('/api/bookings',$data);
        $response->assertSessionHasErrors('email');
    }
}
