<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {
            Customer::create([
                'name' => $faker->name,
                'nik' => $faker->ssn,
                'address' => $faker->address,
                'sex' => $faker->randomElement(['laki-laki', 'perempuan']),
                'slug' => Str::slug($faker->name),
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->email
            ]);
        }
    }
}
