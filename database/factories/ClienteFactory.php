<?php

namespace Database\Factories;

use App\Models\FormaPago;
use App\Models\RegimenFiscal;
use App\Models\TipoCliente;
use App\Models\UsoCFDI;
use Faker\Core\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razon_social' => fake()->company(),
            'direccion' => fake()->address(),
            'rfc' => fake()->uuid(),
            'email' => fake()->companyEmail(),
            'telefono' => fake()->phoneNumber(),
            'codigo_postal' => fake()->postcode(),
            'ciudad' => fake()->city(),
            'estado' => fake()->city(),
            'plazo' => rand(0,10),
            'regimen_fiscal' => RegimenFiscal::all()->random(1)[0]->c_RegimenFiscal,
            'contacto_administrativo' => fake()->email(),
            'contacto_operativo' => fake()->email(),
            'tipo_cliente_id' => TipoCliente::all()->random(1)[0]->id,
            'forma_pago' => FormaPago::all()->random(1)[0]->c_FormaPago,
            'uso_cfdi' => UsoCFDI::all()->random(1)[0]->c_UsoCFDI,
            'estatus' => fake()->boolean()
        ];
    }
}
