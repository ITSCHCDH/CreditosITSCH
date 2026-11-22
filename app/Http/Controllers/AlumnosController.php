<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Controllers\Utilities\DataTableAttr;
use App\Http\Controllers\Utilities\DataTableHelper;
use App\Http\Controllers\Utilities\HttpCode;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Sit\Alumno as SitAlumno;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumnosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS')
            ->only(['index', 'cargarAlumnosAjax', 'buscar']);
    }

    public function index()
    {
        return view('admin.alumnos.index');
    }

    public function cargarAlumnosAjax(Request $request)
    {
        try {
            $selectColumns = [
                DB::raw("CONCAT_WS(' ', u.apellido_paterno, u.apellido_materno, u.nombre) as nombre"),
                'alu.no_control',
                'u.email',
                'alu.estatus as status',
                'alu.id as alumno_id',
                'c.nombre as carrera',
            ];
            $dtAttr = new DataTableAttr($request, $selectColumns);

            $alumnos = DB::connection('sit')
                ->table('alumnos as alu')
                ->join('users as u', 'u.id', '=', 'alu.user_id')
                ->join('cat_carreras as c', 'c.id', '=', 'alu.carrera_id')
                ->select($selectColumns);

            DataTableHelper::applyAllExcept($alumnos, $dtAttr, [DataTableHelper::PAGINATOR]);

            $visibles = $alumnos instanceof LengthAwarePaginator
                ? collect($alumnos->items())
                : collect($alumnos);
            $perfiles = AlumnoCreditosPerfil::whereIn(
                'no_control',
                $visibles->pluck('no_control')
            )->pluck('estatus_creditos', 'no_control');

            foreach ($alumnos as $alumno) {
                $alumno->status = $perfiles[$alumno->no_control] ?? 'pendiente';
                $alumno->status = ucwords(str_replace('_', ' ', $alumno->status));
            }

            return response()->json(
                DataTableHelper::paginatorResponse($alumnos, $dtAttr),
                HttpCode::SUCCESS
            );
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::NOT_ACCEPTABLE);
        }
    }

    public function perfil($id)
    {
        $alumno = SitAlumno::with(['user', 'carrera'])->findOrFail($id);
        $perfil = AlumnoCreditosPerfil::obtenerOCrear($alumno->no_control);

        return view('alumnos.perfil')->with('alumno_data', collect([
            (object) [
                'nombre' => $alumno->nombreCompleto,
                'no_control' => $alumno->no_control,
                'foto' => $perfil->foto,
                'alumno_id' => $alumno->id,
                'carrera' => $alumno->carrera?->nombre,
            ],
        ]));
    }

    public function editPerfil($id, Request $request)
    {
        $alumno = SitAlumno::findOrFail($id);
        $request->validate([
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $size = getimagesize($file->getRealPath());

            if (! $size || $size[0] < 200 || $size[1] < 200) {
                Alert::error('Error', 'La fotografía debe medir al menos 200px de alto y 200px de ancho.');
                return back()->withInput();
            }

            Storage::disk('public')->makeDirectory('alumnos/img');
            $name = 'foto_'.$alumno->no_control.'.'.strtolower($file->getClientOriginalExtension());
            $file->storeAs('alumnos/img', $name, 'public');

            $perfil = AlumnoCreditosPerfil::obtenerOCrear($alumno->no_control);
            $perfil->foto = $name;
            $perfil->save();
        }

        Alert::success('Correcto', 'Su perfil fue modificado con éxito.');
        return redirect()->route('alumnos.perfil', $id);
    }

    public function buscar(Request $request)
    {
        $sitAlumno = SitAlumno::with(['user', 'carrera'])
            ->where('no_control', $request->input('control'))
            ->first();

        if (! $sitAlumno) {
            Alert::error('Error', 'Alumno no encontrado');
            return view('admin.alumnos.bajas')->with('alumno', collect());
        }

        $perfil = AlumnoCreditosPerfil::obtenerOCrear($sitAlumno->no_control);
        $alumno = collect([
            (object) [
                'no_control' => $sitAlumno->no_control,
                'nombre' => $sitAlumno->nombreCompleto,
                'carrera' => $sitAlumno->carrera?->nombre,
                'status' => $perfil->estatus_creditos,
            ],
        ]);

        return view('admin.alumnos.bajas')->with('alumno', $alumno);
    }
}
