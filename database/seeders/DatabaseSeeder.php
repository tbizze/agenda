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

        // Roda um conjunto de Seeder.
        $this->call([
            
            // Permissões e usuário.
            //PermissionSeeder::class,    //criar funções e permissões
            //UserSeeder::class,          // criar usuários
            
            // Módulo Pessoas.
            /* EventoGrupoSeeder::class,
            EventoAreaSeeder::class,
            EventoLocalSeeder::class,
            EventoSeeder::class, */

            ReciboSeeder::class,


        ]);
    }
}
