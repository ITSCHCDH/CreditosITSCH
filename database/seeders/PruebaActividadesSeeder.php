<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Credito;
use App\Models\Sit\Carrera;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PruebaActividadesSeeder extends Seeder
{
    public function run(): void
    {
        $permissionNames = [
            'AGREGAR_RESPONSABLES',
            'ELIMINAR_RESPONSABLES',
            'VER_RESPONSABLES',
            'AGREGAR_PARTICIPANTES',
            'VER_PARTICIPANTES',
            'CREAR_EVIDENCIA',
            'VER_EVIDENCIA',
        ];

        foreach ($permissionNames as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $role = Role::findOrCreate('Responsable de Prueba', 'web');
        $role->syncPermissions($permissionNames);

        $creditIds = Credito::where('vigente', 'true')
            ->orderBy('id')
            ->pluck('id');

        if ($creditIds->isEmpty()) {
            $this->command->warn('No hay créditos vigentes. Ejecuta CrearCreditos antes de este seeder.');
            return;
        }

        $carreraId = Carrera::where('activo', 1)->orderBy('id')->value('id');
        $areaId = DB::table('areas')->where('tipo', 'otro')->orderBy('id')->value('id');
        if (! $areaId) {
            $areaId = DB::table('areas')->insertGetId([
                'nombre' => 'Administrativo',
                'tipo' => 'otro',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($index = 1; $index <= 10; $index++) {
            $user = User::updateOrCreate(
                ['email' => "responsable{$index}@prueba.itsch.mx"],
                [
                    'name' => "Responsable de Prueba {$index}",
                    'password' => Hash::make('Prueba123!'),
                    'area' => $areaId,
                    'sit_carrera_id' => $carreraId,
                    'active' => 'true',
                    'tutor' => 0,
                ]
            );

            $user->assignRole($role);
        }

        for ($index = 1; $index <= 10; $index++) {
            Actividad::updateOrCreate(
                ['nombre' => "Actividad de prueba {$index}"],
                [
                    'por_cred_actividad' => 10,
                    'id_user' => 1,
                    'id_actividad' => $creditIds[($index - 1) % $creditIds->count()],
                    'vigente' => 'true',
                    'alumnos' => $index % 2 === 0 ? 'true' : 'false',
                    'fecCierre' => now()->addMonths(2)->addDays($index)->format('Y-m-d'),
                ]
            );
        }

        $this->command->info('Prueba creada: 10 usuarios responsables y 10 actividades vigentes.');
    }
}
