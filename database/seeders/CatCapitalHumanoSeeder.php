<?php

namespace Database\Seeders;

use App\Models\CatCentroCosto;
use App\Models\CatDepartamento;
use App\Models\CatEmpleadosDocumentos;
use App\Models\CatPuesto;
use App\Models\CatTipoNomina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatCapitalHumanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatCentroCosto::upsert(
           [
            ['id' => 1, 'nombre' =>	'Laredo'],
            ['id' => 2, 'nombre' =>	'Mexico'],
            ['id' => 3, 'nombre' =>	'Puebla'],
            ['id' => 4, 'nombre' =>	'TRATA USA'],
            ['id' => 5, 'nombre' =>	'WISE']
           ],
           ['id'], ['nombre']
        );

        CatDepartamento::upsert([
            ['id'=> 1, 'nombre' => 'Administracion'],
            ['id'=> 2, 'nombre' => 'Cruce'],
            ['id'=> 3, 'nombre' => 'Mantenimiento'],
            ['id'=> 4, 'nombre' => 'Operación'],
            ['id'=> 5, 'nombre' => 'Puebla'],
            ['id'=> 6, 'nombre' => 'Trafico']
        ], ['id'], ['nombre']);

        CatTipoNomina::upsert([
            ['id' => 1, 'nombre' =>	'Mensual'],
            ['id' => 2, 'nombre' =>	'Quincenal'],
            ['id' => 3, 'nombre' =>	'Semanal']
        ], ['id'], ['nombre']);

        CatPuesto::upsert([
            ['id' => 1, 'nombre' => 'Analista de Cobranza'],
            ['id' => 2, 'nombre' => 'Analista de Gestion de Mejora'],
            ['id' => 3, 'nombre' => 'Analista de Gestion de Seguridad'],
            ['id' => 4, 'nombre' => 'Analista de Liquidaciones'],
            ['id' => 5, 'nombre' => 'Analista de Mesa de Control'],
            ['id' => 6, 'nombre' => 'Analista TI'],
            ['id' => 7, 'nombre' => 'Auxiliar de Almacen'],
            ['id' => 8, 'nombre' => 'Auxiliar de Capital Humano'],
            ['id' => 9, 'nombre' => 'Auxiliar de Mantenimiento'],
            ['id' => 10, 'nombre' => 'Becario'],
            ['id' => 11, 'nombre' => 'Capital Humano'],
            ['id' => 12, 'nombre' => 'Carrosero'],
            ['id' => 13, 'nombre' => 'Control de Equipo y Daños'],
            ['id' => 14, 'nombre' => 'Coordinador de Exportación'],
            ['id' => 15, 'nombre' => 'Coordinador de Cruces'],
            ['id' => 16, 'nombre' => 'Coordinador de Importación'],
            ['id' => 17, 'nombre' => 'Coordinador de Operaciones'],
            ['id' => 18, 'nombre' => 'Cuentas por Pagar'],
            ['id' => 19, 'nombre' => 'Despachador B1'],
            ['id' => 20, 'nombre' => 'Despachador Diesel'],
            ['id' => 21, 'nombre' => 'Ejecutivo de Logística'],
            ['id' => 22, 'nombre' => 'Encargado Operaciones Puebla'],
            ['id' => 23, 'nombre' => 'Encargado Patio Puebla'],
            ['id' => 24, 'nombre' => 'Facturacion'],
            ['id' => 25, 'nombre' => 'Gerente Administrativo'],
            ['id' => 26, 'nombre' => 'Gerente de Operaciones'],
            ['id' => 27, 'nombre' => 'Gestion de Calidad'],
            ['id' => 28, 'nombre' => 'Guardia de Seguridad'],
            ['id' => 29, 'nombre' => 'Guardia Intercambista'],
            ['id' => 30, 'nombre' => 'Guardia Puebla'],
            ['id' => 31, 'nombre' => 'Guardia Seguridad'],
            ['id' => 32, 'nombre' => 'Limpieza'],
            ['id' => 33, 'nombre' => 'Mecanico'],
            ['id' => 34, 'nombre' => 'Monitoreo'],
            ['id' => 35, 'nombre' => 'Operador B1'],
            ['id' => 36, 'nombre' => 'Operador de Carretera'],
            ['id' => 37, 'nombre' => 'Operador De Cruce'],
            ['id' => 38, 'nombre' => 'Pricing'],
            ['id' => 39, 'nombre' => 'Safety'],
            ['id' => 40, 'nombre' => 'Supervisor de Mantenimento'],
            ['id' => 41, 'nombre' => 'Supervisor de Monitoreo'],
            ['id' => 42, 'nombre' => 'Talachero']
        ], ['id'], ['nombre']);

        CatEmpleadosDocumentos::upsert([
            ['id' => 1, 'nombre' => 'Acta De Nacimiento'],
            ['id' => 2, 'nombre' => 'Comprobante De Domicilio'],
            ['id' => 3, 'nombre' => 'INE'],
            ['id' => 4, 'nombre' => 'Constancia De Situacion Fiscal'],
            ['id' => 5, 'nombre' => 'Constancia Del IMSS'],
            ['id' => 6, 'nombre' => 'Aviso De Descuento Del IMSS'],
            ['id' => 7, 'nombre' => 'Visa LASER'],
            ['id' => 8, 'nombre' => 'Carta De Antecedentes No Penales'],
            ['id' => 9, 'nombre' => 'Cartilla Militar'],
            ['id' => 10, 'nombre' => 'Comprobante De Estudios'],
            ['id' => 11, 'nombre' => 'CURP'],
            ['id' => 12, 'nombre' => 'Licencia Federal'],
            ['id' => 13, 'nombre' => 'Cartas De Recomendacion Laboral'],
            ['id' => 14, 'nombre' => 'Constancia De Apto Medico'],
            ['id' => 15, 'nombre' => 'Permiso FAST'],
            ['id' => 16, 'nombre' => 'SENTRI'],
            ['id' => 17, 'nombre' => 'Verificacion Lic']
        ], ['id'], ['nombre']);
    }
}
