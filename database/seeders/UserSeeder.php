<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@procafes.test'],
            [
                'name' => 'Administrador',
                'password' => 'Admin123!',     // se hashea por el cast del modelo
                'role' => 'admin',
                'phone' => '999999999',
                'address' => 'Pichanaki, Junín, Perú',
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
            ]
        );

        // Cliente
        User::updateOrCreate(
            ['email' => 'cliente@procafes.test'],
            [
                'name' => 'Cliente Demo',
                'password' => 'Cliente123!',   // se hashea por el cast del modelo
                'role' => 'customer',
                'phone' => '988888888',
                'address' => 'Pichanaki, Junín, Perú',
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
            ]
        );
    }
}
