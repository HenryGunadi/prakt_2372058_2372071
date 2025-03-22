<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surat')->insert([
            [
                'id' => 1,
                'jenis' => 'Keterangan Mahasiswa Aktif',
                'status' => 'applied',
                'mahasiswa_nrp' => '2372001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'jenis' => 'Laporan Hasil Studi',
                'status' => 'rejected',
                'mahasiswa_nrp' => '2372001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'jenis' => 'Pengantar Tugas Mata Kuliah',
                'status' => 'finished',
                'mahasiswa_nrp' => '2372001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
