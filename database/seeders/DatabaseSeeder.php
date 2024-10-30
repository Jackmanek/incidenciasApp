<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'administrador',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Julia',
            'email' => 'julia@example.com',
            'password' => 'password',
            'role' => 'administrador',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jose',
            'email' => 'jose@example.com',
            'password' => 'password',
            'role' => 'soporte',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Lucia',
            'email' => 'lucia@example.com',
            'password' => 'password',
            'role' => 'soporte',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Lierni',
            'email' => 'lierni@example.com',
            'password' => 'password',
            'role' => 'soporte',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Maider',
            'email' => 'maider@example.com',
            'password' => 'password',
            'role' => 'soporte',
        ]);


    }
}
