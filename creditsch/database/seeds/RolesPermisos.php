<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\User;

class RolesPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        //Permisos relacionados a evidencias
        Permission::create(['name' => 'CREAR_EVIDENCIA']);
        Permission::create(['name' => 'ELIMINAR_EVIDENCIA']);
        Permission::create(['name' => 'MODIFICAR_EVIDENCIA']);
        Permission::create(['name' => 'VER_EVIDENCIA']);
        Permission::create(['name' => 'VERIFICAR_EVIDENCIA']);
        Permission::create(['name' => 'VIP_EVIDENCIA']);
                
        //Permisos relacionados a actividadades
        Permission::create(['name' => 'CREAR_ACTIVIDAD']);
        Permission::create(['name' => 'ELIMINAR_ACTIVIDAD']);
        Permission::create(['name' => 'VER_ACTIVIDAD']);
        Permission::create(['name' => 'MODIFICAR_ACTIVIDAD']);
        Permission::create(['name' => 'CREAR_ACTIVIDAD_ALUMNOS']);
        Permission::create(['name' => 'VIP_ACTIVIDAD']);
        
       	//Permisos relacionados con alumnos
        Permission::create(['name' => 'CREAR_ALUMNOS']);
        Permission::create(['name' => 'ELIMINAR_ALUMNOS']);
        Permission::create(['name' => 'MODIFICAR_ALUMNOS']);
        Permission::create(['name' => 'VER_ALUMNOS']);
       	
       	//Permisos relacionado con usuarios
       	Permission::create(['name' => 'CREAR_USUARIOS']);
       	Permission::create(['name' => 'ELIMINAR_USUARIOS']);
       	Permission::create(['name' => 'MODIFICAR_USUARIOS']);
       	Permission::create(['name' => 'VER_USUARIOS']);
       	
       	//Permisos relacionados con participantes
        Permission::create(['name' => 'AGREGAR_PARTICIPANTES']);
        Permission::create(['name' => 'ELIMINAR_PARTICIPANTES']);
        Permission::create(['name' => 'VER_PARTICIPANTES']);
		        
        //Permisos relacionados con responsables
        Permission::create(['name' => 'AGREGAR_RESPONSABLES']);
        Permission::create(['name' => 'ELIMINAR_RESPONSABLES']);
        Permission::create(['name' => 'VER_RESPONSABLES']);

        //Permisos relacionados con creditos
        Permission::create(['name' => 'CREAR_CREDITOS']);
        Permission::create(['name' => 'ELIMINAR_CREDITOS']);
        Permission::create(['name' => 'VER_CREDITOS']);
        Permission::create(['name' => 'MODIFICAR_CREDITOS']);
        
        //Permisos relacionados a reportes
        Permission::create(['name' => 'VER_REPORTES_CARRERA']);
        Permission::create(['name' => 'VIP_REPORTES']);

        //Permisos relacionados a ver los avances de los alumnos
        Permission::create(['name' => 'VER_AVANCE_ALUMNO']);

        //Permisos relacionado a roles
        Permission::create(['name' => 'ASIGNAR_REMOVER_ROLES_USUARIOS']);
        Permission::create(['name' => 'CREAR_ROLES']);
        Permission::create(['name' => 'ELIMINAR_ROLES']);
        Permission::create(['name' => 'MODIFICAR_ROLES']);
        Permission::create(['name' => 'VER_ROLES']);
        Permission::create(['name' => 'VER_ROLES_USUARIOS']);
        Permission::create(['name' => 'ELIMINAR_ROLES_USUARIOS']);
        Permission::create(['name' => 'ASIGNAR_REMOVER_PERMISOS_A_ROLES']);
       	
       	//Permisos relacionados a constancias
       	Permission::create(['name' => 'MODIFICAR_CONSTANCIAS_CARRERA']);
       	Permission::create(['name' => 'VIP_CONSTANCIAS']);
       	Permission::create(['name' => 'IMPRIMIR_CONSTANCIAS']);
       	
       	//Permisos relacionado a administrador
       	Permission::create(['name' => 'VIP']);
       	Permission::create(['name' => 'VIP_SOLO_LECTURA']);

       	//Creacion de un administrador por defecto
       	DB::table('users')->insert([
       		'name' => 'Admin',
       		'email' => 'Admin@itsch.com',
       		'password' => bcrypt('Jaguares'),
       		'area' => 'Administración',
       		'active' => 'true',
       	]);
        $user = User::find(1);
        $user->givePermissionTo('VIP');
    }
}
