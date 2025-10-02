<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LocationSetting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@sekolah.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create Guru Users
        $gurus = [
            [
                'name' => 'Guru Matematika',
                'email' => 'guru.matematika@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip' => '196510051992031001',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Guru Bahasa Indonesia',
                'email' => 'guru.bahasa@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip' => '196812151995122001',
                'phone' => '081234567892',
            ],
            [
                'name' => 'Guru IPA',
                'email' => 'guru.ipa@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip' => '197203201998031002',
                'phone' => '081234567893',
            ],
        ];

        foreach ($gurus as $guru) {
            User::create($guru);
        }

        // Create Location Setting
        LocationSetting::create([
            'latitude' => -6.2087634,
            'longitude' => 106.845599,
            'radius' => 100,
            'created_by' => 1,
        ]);

        $this->command->info('Demo data created successfully!');
        $this->command->info('Admin Login: admin@sekolah.id / password');
        $this->command->info('Guru Login: guru.matematika@sekolah.id / password');
    }
}