<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surat_detail')->insert([
            [
                'id' => 1,
                'subjek' => null,
                'keperluan' => 'Testing',
                'mata_kuliah' => 'AI',
                'semester' => 4,
                'surat_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'subjek' => 'Sakit tesing',
                'keperluan' => 'Testing',
                'mata_kuliah' => 'Deep Learning',
                'semester' => 4,
                'surat_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'subjek' => null,
                'keperluan' => 'Lol',
                'mata_kuliah' => null,
                'semester' => 4,
                'surat_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
