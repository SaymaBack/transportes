<?php

namespace Database\Seeders;

use App\Models\CatDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatDocumento::upsert([
            ['id' => 1, 'nombre' => 'Constancia de sistuacion fiscal del mes y año en curso con codigo bidimensional', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2])],
            ['id' => 2, 'nombre' => 'Opinión del cumplimiento de obligaciones fiscales actualizada positiva', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2])],
            ['id' => 3, 'nombre' => 'Acta constitutiva', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1])],
            ['id' => 4, 'nombre' => 'Poder notarial del representante legal (actos de administracion)', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1])],
            ['id' => 5, 'nombre' => 'W9 o W8', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([3])],
            ['id' => 6, 'nombre' => 'Articles of incorporation', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([3])],
            ['id' => 7, 'nombre' => 'Contrato de transporte Terrestre de Carga', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 8, 'nombre' => 'Identificacion oficial del representante legal', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 9, 'nombre' => 'Comprobante de domicilio no mayor a 60 dias', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 10, 'nombre' => 'Convenio de colaboracion CTPAT/OEA firmado por el representante legal', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 11, 'nombre' => 'Cuestionario de seguridad debidamente llenado y firmado', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 12, 'nombre' => 'Evidencia de certificacion OEA/CTPAT', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 13, 'nombre' => 'Fotografia de sus instalaciones', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
            ['id' => 14, 'nombre' => 'Solicitud de credito', 'require_token' => 0, 'active' => 1, 'tipos_clientes' => json_encode([1,2,3])],
        ], ['id'], ['nombre', 'require_token', 'active', 'tipos_clientes']);
    }
}
