<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        User::firstOrCreate(
            ['username' => 'admin'], 
            [
                'name'              => 'Administrator Utama',
                'email'             => 'admin@certilearn.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), 
                'role'              => 'admin', 
                'gender'            => 'L',
                'status'            => 'approved',
            ]
        );


        User::firstOrCreate(
            ['username' => 'budiguru'],
            [
                'name'              => 'Budi Pengajar, S.Kom',
                'email'             => 'guru@certilearn.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), 
                'role'              => 'guru', 
                'gender'            => 'L',
                'nip'               => 'GURU12345', 
                'status'            => 'approved',
            ]
        );


        User::firstOrCreate(
            ['username' => 'naufalguru'],
            [
                'name'              => 'Naufal Pengajar, S.Kom',
                'email'             => 'naufalbaru@certilearn.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), 
                'role'              => 'guru', 
                'gender'            => 'L',
                'nip'               => 'GURU12346', 
                'status'            => 'approved',
            ]
        );

        // 4. Siswa 1
        User::firstOrCreate(
            ['username' => 'siswateladan'],
            [
                'name'              => 'Siswa Teladan',
                'email'             => 'siswa@certilearn.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), 
                'role'              => 'siswa', 
                'gender'            => 'L',
                'nisn'              => '20240001',
                'class'             => 'XI-RPL-1',
                'major'             => 'Rekayasa Perangkat Lunak',
                'status'            => 'approved',
            ]
        );

        // 5. Siswa 2
        User::firstOrCreate(
            ['username' => 'naufalp'],
            [
                'name'              => 'Naufal Pratama',
                'email'             => 'naufal@certilearn.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), 
                'role'              => 'siswa', 
                'gender'            => 'L',
                'nisn'              => '202400012',
                'class'             => 'XI-RPL-1',
                'major'             => 'Rekayasa Perangkat Lunak',
                'status'            => 'approved',
            ]
        );

        $this->command->info('Data Admin, Guru, dan Siswa berhasil diproses!');
        
    }
}
