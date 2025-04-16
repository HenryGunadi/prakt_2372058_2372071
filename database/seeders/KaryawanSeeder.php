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
            [
                'nip' => 7272001,
                'nama' => 'Henry William',
                'email' => '7272001@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 1,
                'role_id' => 1,
            ],
            [
                'nip' => 7272002,
                'nama' => 'Fachrizy',
                'email' => '7272002@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 1,
                'role_id' => 2,
            ],
            [
                'nip' => 7292001,
                'nama' => 'Vernon',
                'email' => '7292001@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 3,
                'role_id' => 1,
            ],
            [
                'nip' => 7292002,
                'nama' => 'Mingyu',
                'email' => '7292002@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 3,
                'role_id' => 2,
            ],
            [
                'nip' => 7282001,
                'nama' => 'Scoups',
                'email' => '7292001@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 2,
                'role_id' => 1,
            ],
            [
                'nip' => 7282002,
                'nama' => 'Doyoung',
                'email' => '7292002@maranatha.ac.id',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'program_studi_id' => 2,
                'role_id' => 2,
            ],
        ]);
    }
}