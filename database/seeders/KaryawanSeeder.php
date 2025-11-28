<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawan = [
            ['id_user' => 1, 'nama_karyawan' => 'Budi Santoso', 'nik' => '3201011010900001', 'tanggal_lahir' => '1990-10-10', 'alamat' => 'Jl. Merdeka No. 1, Jakarta', 'nomor_telepon' => '081234567890'],
            ['id_user' => 2, 'nama_karyawan' => 'Siti Aminah', 'nik' => '3201012011920002', 'tanggal_lahir' => '1992-11-20', 'alamat' => 'Jl. Pahlawan No. 2, Bandung', 'nomor_telepon' => '081234567891'],
            ['id_user' => 3, 'nama_karyawan' => 'Agus Wijaya', 'nik' => '3201011505880003', 'tanggal_lahir' => '1988-05-15', 'alamat' => 'Jl. Sudirman No. 3, Surabaya', 'nomor_telepon' => '081234567892'],
            ['id_user' => 4, 'nama_karyawan' => 'Dina Rahmawati', 'nik' => '3201012503950004', 'tanggal_lahir' => '1995-03-25', 'alamat' => 'Jl. Gajah Mada No. 4, Yogyakarta', 'nomor_telepon' => '081234567893'],
            ['id_user' => 5, 'nama_karyawan' => 'Eko Prasetyo', 'nik' => '3201013008850005', 'tanggal_lahir' => '1985-08-30', 'alamat' => 'Jl. Diponegoro No. 5, Semarang', 'nomor_telepon' => '081234567894'],
        ];

        Karyawan::insert($karyawan);
    }
}
