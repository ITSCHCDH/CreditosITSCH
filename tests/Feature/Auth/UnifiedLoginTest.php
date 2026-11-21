<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Mail\mail_res_pass;

beforeEach(function () {
    config()->set('database.connections.mysql', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
    config()->set('database.connections.sit', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    config()->set('database.default', 'mysql');
    DB::purge('mysql');
    DB::purge('sit');
    DB::setDefaultConnection('mysql');
    Model::setConnectionResolver(app('db'));
    config()->set('auth.guards.web.provider', 'users');
    config()->set('auth.providers.users.model', App\User::class);
    config()->set('auth.guards.alumno.provider', 'alumnos');
    config()->set('auth.providers.alumnos.model', App\Models\Sit\User::class);

    DB::connection('mysql')->statement('CREATE TABLE users (
        id INTEGER PRIMARY KEY,
        name VARCHAR,
        email VARCHAR UNIQUE,
        password VARCHAR,
        area INTEGER,
        active VARCHAR DEFAULT "true",
        tutor INTEGER DEFAULT 0,
        remember_token VARCHAR NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    )');

    DB::connection('sit')->statement('CREATE TABLE users (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR,
        apellido_paterno VARCHAR NULL,
        apellido_materno VARCHAR NULL,
        email VARCHAR UNIQUE,
        celular VARCHAR NULL,
        telefono_casa VARCHAR NULL,
        email_verified_at DATETIME NULL,
        password VARCHAR,
        activo INTEGER DEFAULT 1,
        remember_token VARCHAR NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    )');

    DB::connection('sit')->statement('CREATE TABLE alumnos (
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        no_control VARCHAR,
        carrera_id INTEGER NULL,
        plan_estudio_id INTEGER NULL
    )');

    DB::connection('sit')->statement('CREATE TABLE cat_carreras (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR NULL
    )');

    DB::connection('sit')->statement('CREATE TABLE cat_plan_estudios (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR NULL
    )');

    DB::connection('mysql')->statement('CREATE TABLE password_resets (
        email VARCHAR,
        token VARCHAR,
        created_at DATETIME NULL
    )');

});

it('autentica automaticamente a un administrativo sin seleccionar rol', function () {
    DB::connection('mysql')->table('users')->insert([
        'name' => 'Administrador',
        'email' => 'admin@itsch.mx',
        'password' => Hash::make('secreto'),
        'area' => 1,
        'active' => 'true',
    ]);

    $response = $this->post('/login', [
        'email' => 'admin@itsch.mx',
        'password' => 'secreto',
    ]);

    $response->assertRedirect('/home');
    $this->assertTrue(Auth::guard('web')->check());
});

it('rechaza credenciales administrativas inactivas', function () {
    DB::connection('mysql')->table('users')->insert([
        'name' => 'Inactivo',
        'email' => 'inactivo@itsch.mx',
        'password' => Hash::make('secreto'),
        'area' => 1,
        'active' => 'false',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'inactivo@itsch.mx',
        'password' => 'secreto',
    ]);

    $response->assertRedirect('/login');
    $this->assertFalse(Auth::guard('web')->check());
});

it('autentica automaticamente a un alumno con perfil en sit', function () {
    DB::connection('sit')->table('users')->insert([
        'id' => 10,
        'nombre' => 'Alumno',
        'apellido_paterno' => 'Prueba',
        'apellido_materno' => null,
        'email' => 'alumno@itsch.mx',
        'password' => Hash::make('secreto'),
        'activo' => 1,
    ]);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 20,
        'user_id' => 10,
        'no_control' => 'S21010001',
        'carrera_id' => 1,
        'plan_estudio_id' => 1,
    ]);

    $response = $this->post('/login', [
        'email' => 'alumno@itsch.mx',
        'password' => 'secreto',
    ]);

    $response->assertRedirect('/alumnos/home');
    $this->assertTrue(Auth::guard('alumno')->check());
});

it('rechaza un usuario sit sin perfil de alumno', function () {
    DB::connection('sit')->table('users')->insert([
        'id' => 11,
        'nombre' => 'Docente',
        'apellido_paterno' => 'Prueba',
        'email' => 'docente@itsch.mx',
        'password' => Hash::make('secreto'),
        'activo' => 1,
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'docente@itsch.mx',
        'password' => 'secreto',
    ]);

    $response->assertRedirect('/login');
    $this->assertFalse(Auth::guard('alumno')->check());
});

it('rechaza una contraseña incorrecta', function () {
    DB::connection('mysql')->table('users')->insert([
        'name' => 'Administrador',
        'email' => 'admin2@itsch.mx',
        'password' => Hash::make('correcta'),
        'area' => 1,
        'active' => 'true',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'admin2@itsch.mx',
        'password' => 'incorrecta',
    ]);

    $response->assertRedirect('/login');
    $this->assertFalse(Auth::guard('web')->check());
});

it('logout limpia ambos guards', function () {
    DB::connection('mysql')->table('users')->insert([
        'name' => 'Administrador',
        'email' => 'logout@itsch.mx',
        'password' => Hash::make('secreto'),
        'area' => 1,
        'active' => 'true',
    ]);

    $this->post('/login', [
        'email' => 'logout@itsch.mx',
        'password' => 'secreto',
    ]);

    $this->assertTrue(Auth::guard('web')->check());

    $response = $this->post('/logout');

    $response->assertRedirect('/');
    $this->assertFalse(Auth::guard('web')->check());
    $this->assertFalse(Auth::guard('alumno')->check());
});

it('muestra el formulario de login moderno sin selector de tipo', function () {
    $response = $this->get('/login');

    $response->assertOk();
    $response->assertSee('Iniciar sesión');
    $response->assertSee('Correo electrónico');
    $response->assertDontSee('Tipo de usuario');
    $response->assertDontSee('<select', false);
});

it('envia enlace local a un usuario administrativo', function () {
    Mail::fake();

    DB::connection('mysql')->table('users')->insert([
        'name' => 'Administrador',
        'email' => 'admin-reset@itsch.mx',
        'password' => Hash::make('secreto'),
        'area' => 1,
        'active' => 'true',
    ]);

    $response = $this->post('/perfil/password_reset_link', [
        'email' => 'admin-reset@itsch.mx',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('password_resets', [
        'email' => 'admin-reset@itsch.mx',
    ], 'mysql');
    Mail::assertSent(mail_res_pass::class);
});

it('redirige al alumno activo al portal institucional de recuperacion', function () {
    DB::connection('sit')->table('users')->insert([
        'id' => 12,
        'nombre' => 'Alumno',
        'apellido_paterno' => 'Prueba',
        'apellido_materno' => null,
        'email' => 'alumno-reset@itsch.mx',
        'password' => Hash::make('secreto'),
        'activo' => 1,
    ]);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 22,
        'user_id' => 12,
        'no_control' => 'S21010002',
        'carrera_id' => 1,
        'plan_estudio_id' => 1,
    ]);

    $response = $this->post('/perfil/password_reset_link', [
        'email' => 'alumno-reset@itsch.mx',
    ]);

    $response->assertRedirect('https://sit.cdhidalgo.tecnm.mx/auth/recuperar-password');
});

it('restablece la contraseña de un usuario administrativo con contraseña segura', function () {
    DB::connection('mysql')->table('users')->insert([
        'id' => 5,
        'name' => 'Administrador',
        'email' => 'reset-ok@itsch.mx',
        'password' => Hash::make('Anterior1!'),
        'area' => 1,
        'active' => 'true',
    ]);
    DB::connection('mysql')->table('password_resets')->insert([
        'email' => 'reset-ok@itsch.mx',
        'token' => 'token-valido',
        'created_at' => now(),
    ]);

    $response = $this->post('/perfil/password_reset', [
        'token' => 'token-valido',
        'newPass' => 'NuevaClave1!',
        'repNewPass' => 'NuevaClave1!',
    ]);

    $response->assertRedirect('/login');
    $updated = DB::connection('mysql')->table('users')->where('email', 'reset-ok@itsch.mx')->first();
    $this->assertTrue(Hash::check('NuevaClave1!', $updated->password));
});
