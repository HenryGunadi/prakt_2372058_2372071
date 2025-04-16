<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'nrp' => 2372058,
                'nama' => 'Maher Syalal Lia Siagian',
                'alamat' => 'Jl. Babakan Jeruk Indah II',
            'email' => '2372058@maranatha.ac.id',
                'password' => Hash::make('lol123.'),
                'semester' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 4,
            ],
            [
                'nrp' => 2372071,
                'nama' => 'Henry William Gunadi',
                'alamat' => 'Jl. Karang anyer',
                'email' => '2372071@maranatha.ac.id',
                'password' => Hash::make('lol123.'),
                'semester' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 5,
            ],
            [
                'nrp' => 2372001,
                'nama' => 'Jeon Wonwoo',
                'alamat' => 'Jl. Surya Sumantri',
                'email' => '2372001@maranatha.ac.id',
                'password' => Hash::make('lol123.'),
                'semester' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 6,
            ],
        ]);
    }
}
