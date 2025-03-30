<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('karyawan')->insert([
            [
                'nip' => 2372001,
                'nama' => 'Henry William',
                'email' => '2372001@maranatha.ac.id',
                'password' => '$2y$10$NhDXnkFedN1S./p1RwPG4euzjt2zkGHBf.71Sxxseh1oyxtk8Mi8i',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'program_studi_id' => 1,
                'role_id' => 1,
            ],
            [
                'nip' => 2372002,
                'nama' => 'Fachrizy',
                'email' => '2372002@maranatha.ac.id',
                'password' => '$2y$10$NhDXnkFedN1S./p1RwPG4euzjt2zkGHBf.71Sxxseh1oyxtk8Mi8i',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'program_studi_id' => 1,
                'role_id' => 2,
            ],
        ]);
    }
}
