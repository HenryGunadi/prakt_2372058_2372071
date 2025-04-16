<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('program_studi')->insert([
            [
                'nama_prodi' => 'Teknik Informatika',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'fakultas_id' => 1,
            ], 
            [
                'nama_prodi' => 'Sistem Informasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'fakultas_id' => 1,
            ], 
            [
                'nama_prodi' => 'Kedokteran',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'fakultas_id' => 2,
            ], 
            [
                'nama_prodi' => 'Psikologi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'fakultas_id' => 3,
            ],
        ]);
    }
}
