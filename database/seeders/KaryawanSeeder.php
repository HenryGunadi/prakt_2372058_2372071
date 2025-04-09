<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            // [
            //     'nip' => 2372001,
            //     'nama' => 'Henry William',
            //     'email' => '2372001@maranatha.ac.id',
            //     'password' => '$2y$10$NhDXnkFedN1S./p1RwPG4euzjt2zkGHBf.71Sxxseh1oyxtk8Mi8i',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'program_studi_id' => 1,
            //     'role_id' => 1,
            // ],
            // [
            //     'nip' => 2372002,
            //     'nama' => 'Fachrizy',
            //     'email' => '2372002@maranatha.ac.id',
            //     'password' => '$2y$10$NhDXnkFedN1S./p1RwPG4euzjt2zkGHBf.71Sxxseh1oyxtk8Mi8i',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'program_studi_id' => 1,
            //     'role_id' => 2,
            // ],
            [
                'nip' => 7272009,
                'nama' => 'Agus',
                'email' => 'Agus@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 3,
                'role_id' => 2,
            ],
        ]);
    }
}
