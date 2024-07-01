<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Nama Toko', 'Alamat', 'Nomer Telepon', 'Email', 'Website Url','Logo Depan'];
        $types = ['text', 'text', 'text', 'text', 'text','file'];
        $descriptions = [
            'Rental Mobil',
            Faker::create()->address,
            Faker::create()->phoneNumber,
            Faker::create()->email,
            'https://omeans-team.github.io/',
            'backend/img/logo.jpg',
        ];

        foreach ($names as $key => $name) {
            Setting::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'type' => $types[$key],
                'description' => $descriptions[$key]
            ]);
        }
    }
}
