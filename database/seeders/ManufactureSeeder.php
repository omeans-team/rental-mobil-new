<?php

namespace Database\Seeders;

use App\Models\Manufacture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ManufactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Toyota','Suzuki','Honda','Mercedes-Benz','BMW','Daihatsu','Nissan','Isuzu','KIA','Mitsubishi','Datsun','Mazda','Hyundai','Chevrolet'];

        for($i=0;$i<count($names);$i++){
            $name = $names[$i];
            Manufacture::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
