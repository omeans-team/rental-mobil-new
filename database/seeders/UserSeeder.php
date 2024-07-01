<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Super Admin', 'Admin', 'User'];

        foreach ($names as $name) {
            $role = Role::create([
                'name'=> $name,
                'slug'=> Str::slug($name)
            ]);

            User::create([
                'name'=> $name,
                'username'=> Str::slug($name),
                'role_id'=> $role->id,
                'email' => Str::slug($name) . "@google.com",
                'password' => Hash::make('24121993'),
            ]);

            for ($i = 1; $i <= 5; $i++) {
                // $named = $names[array_rand($names)]; // randomly select a name from the array

                User::create([
                    'name'=> $name . ' ' . $i, // append the incrementing value to the name
                    'username'=> Str::slug($name . ' ' . $i),
                    'role_id'=> $role->id,
                    'email' => Str::slug($name . ' ' . $i) . "@google.com",
                    'password' => Hash::make('24121993'),
                ]);
            }
        }
    }
}
