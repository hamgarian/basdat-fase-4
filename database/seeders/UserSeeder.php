<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'budi.s', 'password' => bcrypt('pass123')],
            ['username' => 'siti.a', 'password' => bcrypt('pass123')],
            ['username' => 'agus.w', 'password' => bcrypt('pass123')],
            ['username' => 'dina.r', 'password' => bcrypt('pass123')],
            ['username' => 'eko.p', 'password' => bcrypt('pass123')],
        ];

        DB::table('user')->insert($users);
    }
}
