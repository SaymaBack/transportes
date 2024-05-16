<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use Illuminate\Database\Seeder;

class TiposClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoCliente::upsert(
            [['id' => 1, 'nombre' => 'PERSONA FÍSICA'], ['id' => 2,'nombre' => 'NACIONAL'], ['id' => 3,'nombre' => 'AMERICANO']],
            ['id'], ['nombre']
        );
    }
}
