<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['username' => 'dev'],
            [
                'username' => 'dev',
                'password' => Hash::make('password'),
                'role' => 'dev',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
