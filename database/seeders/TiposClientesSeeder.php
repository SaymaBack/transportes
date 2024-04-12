<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [[1,'PERSONA FÍSICA'], [2,'NACIONAL'], [3,'AMERICANO']];

        foreach ($tipos as $value) {
            TipoCliente::create(['id' => $value[0], 'nombre' => $value[1]]);
        }
    }
}
