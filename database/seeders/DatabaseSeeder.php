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
        //\App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'username' => 'test.user',
            'name' => 'Test User',
            'password' => bcrypt('123456.')
        ]);

        $this->call([
            TiposClientesSeeder::class,
            ClientesSeeder::class,
            CatDocumentosSeeder::class
        ]);


    }
}
