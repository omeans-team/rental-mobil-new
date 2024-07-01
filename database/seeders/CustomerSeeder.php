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
        $faker = Faker::create('id_ID'); // set the locale to Indonesian
        $generatedNames = []; // store generated names to prevent duplicates
        $generatedEmails = []; // store generated emails to prevent duplicates

        for ($i = 0; $i < 1000; $i++) {

            $name = $this->generateIndonesianName(); // generate a random Indonesian name
            while (in_array($name, $generatedNames)) {
                $name = $this->generateIndonesianName(); // regenerate if duplicate
            }
            $generatedNames[] = $name; // add to array to prevent duplicates


            $email = $faker->email; // generate a random email
            while (in_array($email, $generatedEmails)) {
                $email = $faker->email; // regenerate if duplicate
            }
            $generatedEmails[] = $email; // add to array to prevent duplicates


            Customer::create([
                'name' => $name, // generate a random Indonesian name
                'nik' => $this->generateNik(), // generate a random NIK (Nomor Induk Kependudukan)
                'address' => $this->generateIndonesianAddress(), // generate a random Indonesian address
                'sex' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'slug' => Str::slug($name),
                'phone_number' => $faker->phoneNumber,
                'email' => $email
            ]);
        }
    }

    private function generateIndonesianName()
    {
        $firstName = $this->getRandomIndonesianFirstName();
        $lastName = $this->getRandomIndonesianLastName();

        return $firstName . ' ' . $lastName;
    }

    private function getRandomIndonesianFirstName()
    {
        $firstNames = [
            'Achmad', 'Andi', 'Budi', 'Dedi', 'Eko', 'Fajar', 'Guntur', 'Hendra', 'Iwan', 'Joko',
            'Kurniawan', 'Lukman', 'Mulyadi', 'Nur', 'Oktavian', 'Purnomo', 'Rudi', 'Satria', 'Tono', 'Umar',
            'Vicky', 'Wahyudi', 'Xavier', 'Yudi', 'Zainal',
            'Aisyah', 'Bunga', 'Citra', 'Dewi', 'Eva', 'Fitri', 'Gita', 'Hana', 'Ika', 'Juli',
            'Kartika', 'Lina', 'Mutiara', 'Nadia', 'Oktaviani', 'Pertiwi', 'Ratna', 'Sari', 'Tuti', 'Umi',
            'Vera', 'Wati', 'Xenia', 'Yuli', 'Zahra',
            'Abdul', 'Adi', 'Agus', 'Aldi', 'Ali', 'Amin', 'Ani', 'Anwar', 'Arif', 'Ari',
            'Diana', 'Dina', 'Doni', 'Dwi', 'Eli', 'Elis', 'Ely', 'Emi', 'Endah', 'Eni',
            'Fadil', 'Fahmi', 'Fajar', 'Fani', 'Farid', 'Fauzi', 'Feri', 'Ferry', 'Fika', 'Firdaus'
        ];

        return $firstNames[rand(0, count($firstNames) - 1)];
    }

    private function getRandomIndonesianLastName()
    {
        $lastNames = [
            'Sulistyo', 'Wijaya', 'Prasetyo', 'Santoso', 'Wahyono', 'Sudarsono', 'Hidayat', 'Riyanto', 'Suharto', 'Widodo',
            'Kusnadi', 'Hartono', 'Sutrisno', 'Purnomo', 'Widjaja', 'Santika', 'Hidayati', 'Riyanti', 'Suhartini', 'Widianti',
            'Nugroho', 'Wibowo', 'Mulyono', 'Wahyudi', 'Sudarmo', 'Kurniawan', 'Susanto', 'Kusuma', 'Suryono', 'Purnami',
            'Hartini', 'Santini', 'Suharsono', 'Wahyuni', 'Sudrajat', 'Kuswanto', 'Santoso', 'Widagdo', 'Hidayanto', 'Riyadi'
        ];

        return $lastNames[rand(0, count($lastNames) - 1)];
    }

    private function generateIndonesianAddress()
    {
        $faker = Faker::create();
        $provinces = [
            'Aceh', 'Bali', 'Banten', 'Bengkulu', 'DI Yogyakarta', 'DKI Jakarta', 'Gorontalo', 'Jambi', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Timur', 'Kalimantan Utara', 'Kepulauan Bangka Belitung', 'Kepulauan Riau', 'Lampung', 'Maluku', 'Maluku Utara', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Papua', 'Papua Barat', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara'
        ];

        $cities = [
            'Bandung', 'Jakarta', 'Surabaya', 'Medan', 'Semarang', 'Yogyakarta', 'Bandar Lampung', 'Palembang', 'Makassar', 'Pontianak', 'Banjarmasin', 'Jayapura', 'Manokwari', 'Ambon', 'Ternate', 'Gorontalo', 'Mamuju', 'Kendari', 'Makassar', 'Pekanbaru', 'Padang', 'Jambi', 'Bengkulu', 'Pangkal Pinang', 'Tanjung Pinang', 'Batam', 'Bandar Seri Begawan', 'Pontianak', 'Samarinda', 'Balikpapan', 'Banjarmasin', 'Tarakan'
        ];

        $address = sprintf('%s, %s, %s, Indonesia', $faker->streetAddress, $cities[rand(0, count($cities) - 1)], $provinces[rand(0, count($provinces) - 1)]);

        return $address;
    }

    private function generateNik()
    {
        $faker = Faker::create();
        $provinceCode = rand(11, 97); // generate a random province code (11-97)
        $dateOfBirth = $faker->dateTimeBetween('-70 years', '-18 years'); // generate a random date of birth between 18 and 70 years ago
        $randomNumber = rand(100, 999); // generate a random number

        $nik = sprintf('%02d%02d%02d%04d%03d',
            $provinceCode,
            $dateOfBirth->format('y'),
            $dateOfBirth->format('m'),
            $dateOfBirth->format('d'),
            $randomNumber
        );

        return $nik;
    }
}
