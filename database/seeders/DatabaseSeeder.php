<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Type::factory()->create(['name'=>'pilates']);
        Type::factory()->create(['name'=>'kangoo jumps']);
        User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'api_token' => "nMLxcTS0P05ascNfVMv6Mg85KoXrNrD8F8FyK3WUAe4HgdJeBkBCddHw1YzC",
        ]);
        User::factory(4)->create();
        Room::factory(5)->create();
        $this->call(ProgrammeSeeder::class);
        $this->call(BookingSeeder::class);
    }
}
