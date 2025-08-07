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
                'name' => 'guru1',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Guru',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'guru2',
                'email' => 'guru1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Guru',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'orangtua1',
                'email' => 'ortu1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Orang Tua',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'orangtua2',
                'email' => 'ortu2@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Orang Tua',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
        DB::table('gurus')->insert([
            [
                'user_id' => '2',
                'jenis_kelamin' => 'Laki-laki',
                'nip' => '27272',
                'no_telepon' => '628787821',
            ],
            [
                'user_id' => '3',
                'jenis_kelamin' => 'Perempuan',
                'nip' => '28282',
                'no_telepon' => '628787822',
            ],

        ]);
        DB::table('kelas')->insert([
            [
                'nama' => 'Kelas 1',
            ],

        ]);
        DB::table('mata_pelajarans')->insert([
            [
                'guru_id' => '1',
                'nama' => 'TBI',
                'kode' => 'TBI1',
            ],
            [
                'guru_id' => '2',
                'nama' => 'TKK',
                'kode' => 'TKK1',
            ],
        ]);
        DB::table('jadwals')->insert([
            [
                'guru_id' => '1',
                'mapel_id' => '1',
                'kelas_id' => '1',
                'hari' => 'Senin',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '10:00:00',
            ],
            [
                'guru_id' => '2',
                'mapel_id' => '2',
                'kelas_id' => '1',
                'hari' => 'Selasa',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '11:00:00',
            ],
        ]);
         DB::table('santris')->insert([
            [
                'nama' => 'Agus',
                'nis' => '123456',
                'tanggal_lahir' => now(),
                'jenis_kelamin' => 'Laki-laki',
                'kelas_id' => '1',
                'tanggal_masuk' => now(),
            ],
             [
                'nama' => 'Supri',
                'nis' => '7891011',
                'tanggal_lahir' => now(),
                'jenis_kelamin' => 'Perempuan',
                'kelas_id' => '1',
                'tanggal_masuk' => now(),
            ],
        ]);
        DB::table('orang_tuas')->insert([
            [
                'user_id' => '4',
                'santri_id' => '1',
                'alamat' => 'Dirumah',
                'no_telepon' => '628123456789',
            ],
            [
                'user_id' => '5',
                'santri_id' => '2',
                'alamat' => 'Dirumah',
                'no_telepon' => '628123456799',
            ],
        ]);
    }
}
