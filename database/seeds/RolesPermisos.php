<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermisos extends Seeder
{
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        $permisos = [
            'CREAR_EVIDENCIA',
            'ELIMINAR_EVIDENCIA',
            'VER_EVIDENCIA',
            'VERIFICAR_EVIDENCIA',
            'VIP_EVIDENCIA',
            'VIP_EVIDENCIA_SOLO_LECTURA',
            'CREAR_ACTIVIDAD',
            'ELIMINAR_ACTIVIDAD',
            'VER_ACTIVIDAD',
            'MODIFICAR_ACTIVIDAD',
            'CREAR_ACTIVIDAD_ALUMNOS',
            'VIP_ACTIVIDAD',
            'VIP_ACTIVIDAD_SOLO_LECTURA',
            'CREAR_ALUMNOS',
            'ELIMINAR_ALUMNOS',
            'MODIFICAR_ALUMNOS',
            'VER_ALUMNOS',
            'VIP_ALUMNOS',
            'VIP_ALUMNOS_SOLO_LECTURA',
            'CREAR_USUARIOS',
            'ELIMINAR_USUARIOS',
            'MODIFICAR_USUARIOS',
            'VER_USUARIOS',
            'AGREGAR_PARTICIPANTES',
            'ELIMINAR_PARTICIPANTES',
            'VER_PARTICIPANTES',
            'AGREGAR_RESPONSABLES',
            'ELIMINAR_RESPONSABLES',
            'VER_RESPONSABLES',
            'CREAR_CREDITOS',
            'ELIMINAR_CREDITOS',
            'VER_CREDITOS',
            'MODIFICAR_CREDITOS',
            'VER_REPORTES_CARRERA',
            'VIP_REPORTES',
            'VER_AVANCE_ALUMNO',
            'VIP_AVANCE_ALUMNO',
            'ASIGNAR_REMOVER_ROLES_USUARIOS',
            'CREAR_ROLES',
            'ELIMINAR_ROLES',
            'MODIFICAR_ROLES',
            'VER_ROLES',
            'VER_ROLES_USUARIOS',
            'ASIGNAR_REMOVER_PERMISOS_A_ROLES',
            'MODIFICAR_CONSTANCIAS_CARRERA',
            'VIP_CONSTANCIAS',
            'IMPRIMIR_CONSTANCIAS',
            'CREAR_AREAS',
            'ELIMINAR_AREAS',
            'VER_AREAS',
            'MODIFICAR_AREAS',
            'CREAR_MENSAJES',
            'VIP',
            'VIP_SOLO_LECTURA',
            'VIP_STA',
            'STA_DEP_TUTORIA',
            'STA_TUTOR',
            'STA_COR_CARRERA',
            'STA_PROFESOR',
            'VER_CITAS_MEDICAS',
            'CREAR_CITAS_MEDICAS',
            'MODIFICAR_CITAS_MEDICAS',
            'VIP_MEDICO',
            'VIP_PSICOLOGO',
            'ELIMINAR_CITAS_MEDICAS',
        ];

        foreach ($permisos as $permiso) {
            Permission::findOrCreate($permiso, 'web');
        }

        $areaId = DB::table('areas')->where('tipo', 'otro')->orderBy('id')->value('id');
        if (! $areaId) {
            $areaId = DB::table('areas')->insertGetId([
                'nombre' => 'Administrativo',
                'tipo' => 'otro',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $administrador = User::firstOrCreate(
            ['email' => 'admin@itsch.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Jaguares'),
                'area' => $areaId,
                'active' => 'true',
            ]
        );
        $administrador->givePermissionTo(['VIP', 'VIP_STA']);

        $roles = [
            'Responsable' => [
                'VER_EVIDENCIA',
                'ELIMINAR_EVIDENCIA',
                'AGREGAR_PARTICIPANTES',
                'ELIMINAR_PARTICIPANTES',
                'VER_PARTICIPANTES',
                'CREAR_EVIDENCIA',
            ],
            'Administrador' => [
                'VIP',
            ],
            'SubAdministrador de Actividades' => [
                'CREAR_ACTIVIDAD',
                'VER_ACTIVIDAD',
                'ELIMINAR_ACTIVIDAD',
                'AGREGAR_RESPONSABLES',
                'ELIMINAR_RESPONSABLES',
                'VER_RESPONSABLES',
                'MODIFICAR_ACTIVIDAD',
                'CREAR_MENSAJES',
                'VERIFICAR_EVIDENCIA',
                'VER_EVIDENCIA',
            ],
            'Administrador de Actividades' => [
                'VIP_ACTIVIDAD',
                'CREAR_MENSAJES',
                'VERIFICAR_EVIDENCIA',
            ],
            'Administrador de Evidencias' => [
                'VIP_EVIDENCIA',
                'VERIFICAR_EVIDENCIA',
            ],
            'SubAdministrador de Usuarios' => [
                'CREAR_USUARIOS',
                'ELIMINAR_USUARIOS',
                'MODIFICAR_USUARIOS',
                'VER_USUARIOS',
            ],
            'Jefe de Carrera' => [
                'VER_ALUMNOS',
                'MODIFICAR_ALUMNOS',
                'CREAR_ALUMNOS',
                'ELIMINAR_ALUMNOS',
                'CREAR_ACTIVIDAD',
                'ELIMINAR_ACTIVIDAD',
                'VER_ACTIVIDAD',
                'MODIFICAR_ACTIVIDAD',
                'VERIFICAR_EVIDENCIA',
                'VER_EVIDENCIA',
                'AGREGAR_RESPONSABLES',
                'ELIMINAR_RESPONSABLES',
                'ELIMINAR_EVIDENCIA',
                'VER_REPORTES_CARRERA',
                'IMPRIMIR_CONSTANCIAS',
                'VER_AVANCE_ALUMNO',
                'CREAR_MENSAJES',
                'AGREGAR_PARTICIPANTES',
                'ELIMINAR_PARTICIPANTES',
                'MODIFICAR_CONSTANCIAS_CARRERA',
            ],
        ];

        foreach ($roles as $nombre => $permisosRol) {
            $rol = Role::findOrCreate($nombre, 'web');
            $rol->givePermissionTo($permisosRol);
        }

        app()['cache']->forget('spatie.permission.cache');
    }
}
