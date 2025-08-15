<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'sana',
            'email' => 'tidier.gem.7j@icloud.com',
            'password' => Hash::make('sana4826'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
