<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Las constancias ahora se relacionan con sit.cat_carreras, no con
 * creditos.areas. La tabla estaba vacía, así que solo se elimina la llave
 * foránea que apuntaba a areas.
 */
return new class extends Migration
{
    public function up(): void
    {
        $database = DB::getDatabaseName();

        $existe = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', 'constancia')
            ->where('CONSTRAINT_NAME', 'constancia_carrera_foreign')
            ->exists();

        if ($existe) {
            DB::statement('ALTER TABLE `constancia` DROP FOREIGN KEY `constancia_carrera_foreign`');
        }
    }

    public function down(): void
    {
        // No se restaura: la columna ahora guarda el id de sit.cat_carreras.
    }
};
