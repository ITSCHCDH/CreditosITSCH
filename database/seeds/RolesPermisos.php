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
        Permission::create(['name' => 'VER_EVIDENCIA']);
        Permission::create(['name' => 'VERIFICAR_EVIDENCIA']);
        Permission::create(['name' => 'VIP_EVIDENCIA']);
        Permission::create(['name' => 'VIP_EVIDENCIA_SOLO_LECTURA']);

        //Permisos relacionados a actividades
        Permission::create(['name' => 'CREAR_ACTIVIDAD']);
        Permission::create(['name' => 'ELIMINAR_ACTIVIDAD']);
        Permission::create(['name' => 'VER_ACTIVIDAD']);
        Permission::create(['name' => 'MODIFICAR_ACTIVIDAD']);  
        Permission::create(['name' => 'CREAR_ACTIVIDAD_ALUMNOS']);
        Permission::create(['name' => 'VIP_ACTIVIDAD']);
        Permission::create(['name' => 'VIP_ACTIVIDAD_SOLO_LECTURA']);

       	//Permisos relacionados con alumnos
        Permission::create(['name' => 'CREAR_ALUMNOS']);
        Permission::create(['name' => 'ELIMINAR_ALUMNOS']);
        Permission::create(['name' => 'MODIFICAR_ALUMNOS']);
        Permission::create(['name' => 'VER_ALUMNOS']);
        Permission::create(['name' => 'VIP_ALUMNOS']);
        Permission::create(['name' => 'VIP_ALUMNOS_SOLO_LECTURA']);
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
        Permission::create(['name' => 'VIP_AVANCE_ALUMNO']);

        //Permisos relacionado a roles
        Permission::create(['name' => 'ASIGNAR_REMOVER_ROLES_USUARIOS']);
        Permission::create(['name' => 'CREAR_ROLES']);
        Permission::create(['name' => 'ELIMINAR_ROLES']);
        Permission::create(['name' => 'MODIFICAR_ROLES']);
        Permission::create(['name' => 'VER_ROLES']);
        Permission::create(['name' => 'VER_ROLES_USUARIOS']);
        Permission::create(['name' => 'ASIGNAR_REMOVER_PERMISOS_A_ROLES']);
       	
       	//Permisos relacionados a constancias
       	Permission::create(['name' => 'MODIFICAR_CONSTANCIAS_CARRERA']);
       	Permission::create(['name' => 'VIP_CONSTANCIAS']);
       	Permission::create(['name' => 'IMPRIMIR_CONSTANCIAS']);

        //Permisos relacionados a areas
        Permission::create(['name' => 'CREAR_AREAS']);
        Permission::create(['name' => 'ELIMINAR_AREAS']);
        Permission::create(['name' => 'VER_AREAS']);
        Permission::create(['name' => 'MODIFICAR_AREAS']);

        //Permisos relacionado con mensajes
        Permission::create(['name' => 'CREAR_MENSAJES']);
        
       	//Permisos relacionado a administrador
       	Permission::create(['name' => 'VIP']);
       	Permission::create(['name' => 'VIP_SOLO_LECTURA']);

       	//Creacion de un administrador por defecto
       	DB::table('users')->insert([
          'id' => 1,
       		'name' => 'Admin',
       		'email' => 'admin@itsch.com',
       		'password' => bcrypt('Jaguares'),
       		'area' => 1,
       		'active' => 'true',
       	]);
        $user = User::find(1);
        $user->givePermissionTo('VIP');

        $role = Role::create(['name' => 'Responsable']);
        $role->givePermissionTo(['VER_EVIDENCIA','ELIMINAR_EVIDENCIA','AGREGAR_PARTICIPANTES','ELIMINAR_PARTICIPANTES','VER_PARTICIPANTES','CREAR_EVIDENCIA']);
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(['VIP']);

        $role = Role::create(['name' => 'SubAdministrador de Actividades']);
        $role->givePermissionTo(['CREAR_ACTIVIDAD','VER_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','ELIMINAR_RESPONSABLES','VER_RESPONSABLES','MODIFICAR_ACTIVIDAD','CREAR_MENSAJES','VERIFICAR_EVIDENCIA','VER_EVIDENCIA']);

        $role = Role::create(['name' => 'Administrador de Actividades']);
        $role->givePermissionTo(['VIP_ACTIVIDAD','CREAR_MENSAJES','VERIFICAR_EVIDENCIA']);

        $role = Role::create(['name' => 'Administrador de Evidencias']);
        $role->givePermissionTo(['VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']);

        $role = Role::create(['name' => 'SubAdministrador de Usuarios']);
        $role->givePermissionTo(['CREAR_USUARIOS','ELIMINAR_USUARIOS','MODIFICAR_USUARIOS','VER_USUARIOS']);

        $role = Role::create(['name' => 'Jefe de Carrera']);
        $role->givePermissionTo(['VER_ALUMNOS','MODIFICAR_ALUMNOS','CREAR_ALUMNOS','ELIMINAR_ALUMNOS','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','VER_ACTIVIDAD','MODIFICAR_ACTIVIDAD','VERIFICAR_EVIDENCIA','VER_EVIDENCIA','AGREGAR_RESPONSABLES','ELIMINAR_RESPONSABLES','ELIMINAR_EVIDENCIA','VER_REPORTES_CARRERA','IMPRIMIR_CONSTANCIAS','VER_AVANCE_ALUMNO','CREAR_MENSAJES','AGREGAR_PARTICIPANTES','ELIMINAR_PARTICIPANTES','MODIFICAR_CONSTANCIAS_CARRERA']);

    }
}
