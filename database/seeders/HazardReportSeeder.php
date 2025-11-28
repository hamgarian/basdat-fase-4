<?php

namespace Database\Seeders;

use App\Models\HazardReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HazardReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'id_karyawan' => 1,
                'nama_pelapor' => 'Budi Santoso',
                'tanggal_laporan' => '2023-09-15',
                'kategori' => 'FOD',
                'deskripsi' => 'Ditemukan baut di apron C3',
                'status' => 'Investigated',
            ],
            [
                'id_karyawan' => 4,
                'nama_pelapor' => 'Dina Rahmawati',
                'tanggal_laporan' => '2023-09-20',
                'kategori' => 'Ground Handling',
                'deskripsi' => 'Prosedur baggage loading tidak sesuai manual',
                'status' => 'Open',
            ],
            [
                'id_karyawan' => 5,
                'nama_pelapor' => 'Eko Prasetyo',
                'tanggal_laporan' => '2023-09-21',
                'kategori' => 'Maintenance',
                'deskripsi' => 'Torque wrench belum dikalibrasi',
                'status' => 'In Progress',
            ],
            [
                'id_karyawan' => 1,
                'nama_pelapor' => 'Budi Santoso',
                'tanggal_laporan' => '2023-09-22',
                'kategori' => 'Wildlife',
                'deskripsi' => 'Terlihat banyak burung di sekitar runway 25',
                'status' => 'Mitigated',
            ],
            [
                'id_karyawan' => 2,
                'nama_pelapor' => 'Siti Aminah',
                'tanggal_laporan' => '2023-09-25',
                'kategori' => 'Documentation',
                'deskripsi' => 'Logbook penerbangan tidak lengkap',
                'status' => 'Open',
            ],
        ];

        HazardReport::insert($reports);
    }
}
