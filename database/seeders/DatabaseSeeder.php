<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
             [
                'name' => 'guru',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Guru',
                'created_at' => date('Y-m-d H:i:s')
            ],
             [
                'name' => 'orangtua',
                'email' => 'ortu@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Orang Tua',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
