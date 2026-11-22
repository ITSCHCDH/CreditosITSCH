<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use Illuminate\Support\Facades\DB;
use App\Models\AsignacionTutores;
use App\Models\Sit\Carrera;
use App\Models\Sit\Catedratico;
use App\Services\Sit\CarrerasSitService;
use Alert;
use PDF;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getGruposCar(Request $request)
    {
        //Obtenemos los grupos de la base de datos
        $grupos = Grupo::where('id_Carrera',$request->car_Clave)
        ->where('gpo_Semestre',$request->gpo_Semestre)
        ->where('gpo_Status',0)
        ->get();
        //Retornamos los grupos en json
        return response()->json($grupos);
    }

    //Función que debuelve todos los grupos creados
    public function getGruposAll()
    {
        //Obtenemos los grupos de la base de datos
        $grupos = Grupo::all();
        //Obtenemos las carreras equivalentes en SIT
        $carreras = CarrerasSitService::opcionesPorArea();        
        //Agregamos el nombre de la carrera a cada grupo
        foreach ($grupos as $grupo) {
            $grupo->gpo_Carrera = CarrerasSitService::nombreDeArea($grupo->id_Carrera);
        }
        //Retornamos la vista de grupos con los grupos obtenidos
        return view('sta.tutorias.grupos',compact('grupos','carreras'));
    }

    //Función para guardar los grupos con el modelo Grupo
    public function saveGrupo(Request $request)
    { 
        try
        {
            $request->validate([
                'gpo_Nombre' => ['required','string','max:10'],
                'gpo_Semestre' => ['nullable','string','max:15'],
                'id_Carrera' => ['required','integer'],
            ]);
             //Verificamos si el grupo existe y solo si no, lo damos de alta
            $grupoExiste=Grupo::where([
                ['gpo_Nombre','=',$request->gpo_Nombre],
                ['id_Carrera','=',$request->id_Carrera],
                ['gpo_Semestre','=',$request->gpo_Semestre],
                ['id','<>',$request->id]
            ])->get()->count()>0?true: false;       
            if($grupoExiste){
                Alert::error('Error','Este grupo ya se encuentra dado de alta');
                return redirect()->back();
            }
            //Creamos el grupo
            $grupo = new Grupo();
            $grupo->gpo_Nombre = $request->gpo_Nombre;
            if (! Carrera::where('activo',1)->whereKey($request->id_Carrera)->exists()) {
                Alert::error('Error','La carrera SIT no existe');
                return redirect()->back();
            }
            $grupo->id_Carrera = $request->id_Carrera;
            $grupo->gpo_Status = 0;
            $grupo->gpo_Semestre= $request->gpo_Semestre;
            $grupo->save();
            Alert::success('Correcto',"El grupo se ha guardado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.getGruposAll');
        }
        catch(\Exception $e)
        {
            Alert::error('Error','Ocurrio un error al guardar el grupo');
            return redirect()->back();
        }            
    }

    //Función para eliminar un grupo    
    public function deleteGrupo($id)
    {  
        try
        {
            //Obtenemos el grupo a eliminar
            $grupo = Grupo::find($id);
            //Eliminamos el grupo
            $grupo->delete();
            Alert::success('Correcto',"El grupo se ha eliminado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.getGruposAll');
        }
        catch(\Exception $e)
        {
            Alert::error('Error','Ocurrio un error al eliminar el grupo, ya que tiene un tutor asignado');
            return redirect()->back();
        }
       
    }

    //Función para modificar un grupo
    public function updateGrupo(Request $request, $id)
    {   try
        {
            $request->validate([
                'gpo_Nombre' => ['required','string','max:10'],
                'gpo_Semestre' => ['nullable','string','max:15'],
                'id_Carrera' => ['required','integer'],
            ]);
            //Obtenemos el grupo a modificar
            $grupo = Grupo::find($id); 
            //Actualizamos el grupo
            $grupo->gpo_Nombre = $request->gpo_Nombre;
            if (! Carrera::where('activo',1)->whereKey($request->id_Carrera)->exists()) {
                Alert::error('Error','La carrera SIT no existe');
                return redirect()->back();
            }
            $grupo->id_Carrera = $request->id_Carrera;
            $grupo->gpo_Status = $request->gpo_Status;
            $grupo->gpo_Semestre= $request->gpo_Semestre;
            $grupo->save();
            Alert::success('Correcto',"El grupo se ha actualizado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.getGruposAll');
        }
        catch(\Exception $e)
        {
            Alert::error('Error','Ocurrio un error al modificar el grupo');
            return redirect()->back();
        }
       
    }

    //Funcion para guardar los grupos de tutorias
    public function saveGrupoTut(Request $request)
    {    
        $request->validate([
            'gpo_Id' => ['required','integer','exists:grupos,id'],
            'tut_Clave' => ['required','integer'],
            'car_Clave' => ['required','integer'],
        ]);
        if (! Catedratico::where('activo', 1)->whereKey($request->tut_Clave)->exists()) {
            Alert::error('Error','El catedrático SIT no existe o está inactivo');
            return redirect()->back();
        }
        if (! Carrera::where('activo',1)->whereKey($request->car_Clave)->exists()) {
            Alert::error('Error','La carrera SIT no existe');
            return redirect()->back();
        }
        //Obtetemos el año actual
        $año = date("Y");   
        //Guarda el grupo si no existe en la tabla de grupos
        $grupo=AsignacionTutores::updateOrCreate(
            ['gpo_Id'=> $request->gpo_Id , 'tut_Clave' => $request->tut_Clave],
            ['gtu_Tipo'=>$request->gtu_Tipo,'gtu_Semestre'=>$request->gtu_Semestre,'car_Clave'=>$request->car_Clave,'gtu_Año'=>$año]
        );    

        if ($grupo->wasRecentlyCreated) {     
            // Cambiamos el status del grupo a 1
            $grupo = Grupo::find($request->gpo_Id);
            $grupo->gpo_Status = 1;    
            $grupo->save();   
            Alert::success('Correcto',"El grupo se ha asignado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');                    
        } 
        else {           
            Alert::error('Error',"Ocurrio un error al asignar el grupo");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');
        }        
    }

    //Función para eliminar un grupo
    public function tutoriasDestroy($id, Request $request)
    {   
        try {
            //Obtenemos el grupo a eliminar
            $grupoTut = AsignacionTutores::find($id);
            //Eliminamos el grupo
            $grupoTut->delete();
            // Cambiamos el status del grupo a 0
            $grupo = Grupo::find($request->gpo_Id); 
            $grupo->gpo_Status = 0;    
            $grupo->save(); 
            //Quitamos los alumnos asignados a este grupo de la tabla gpo_tutorias
            DB::table('gpo_tutorias')->where('gpo_Nombre',$request->gpo_Nombre)->delete();            
            Alert::success('Correcto',"El grupo se ha eliminado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');
        } catch (\Throwable $th) {
            Alert::error('Error',"Ocurrio un error al eliminar el grupo");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');
        }       
    }

    //Función para imprimir la asignacion del tutor en PDF
    public function asigTutPDF($id)
    {
        //Obtenemos los datos de la asignacion del tutor
        $data = DB::table('asignaciones_tutores')
        ->join('grupos','asignaciones_tutores.gpo_Id','=','grupos.id')       
        ->select('asignaciones_tutores.*','grupos.gpo_Nombre')
        ->where('asignaciones_tutores.id',$id)
        ->first();
        $catedratico = Catedratico::with('user')->whereKey($data->tut_Clave)->first();
        $data->name = $catedratico
            ? trim(implode(' ', array_filter([$catedratico->user?->nombre, $catedratico->user?->apellido_paterno, $catedratico->user?->apellido_materno])))
            : 'Catedrático no encontrado';
        //Obtenemos el nombre de la carrera y se lo asignamos a la variable
        $data->car_Nombre = CarrerasSitService::nombreDeArea($data->car_Clave);
        //Abrimos el editor de PDF y le enviamos la vista que diseñamos para la impresión              
        return PDF::loadView('sta.tutorias.asigTutPDF', compact('data'))
        ->setPaper('letter', 'portrait')
        ->stream('Asignación de tutorias.pdf');
    }

    //Función para imprimir la asignacion del tutor en PDF
    public function libTutPDF($id)
    {
        //Obtenemos los datos de la asignacion del tutor
        $data = DB::table('asignaciones_tutores')
        ->join('grupos','asignaciones_tutores.gpo_Id','=','grupos.id')       
        ->select('asignaciones_tutores.*','grupos.gpo_Nombre')
        ->where('asignaciones_tutores.id',$id)
        ->first();
        $catedratico = Catedratico::with('user')->whereKey($data->tut_Clave)->first();
        $data->name = $catedratico
            ? trim(implode(' ', array_filter([$catedratico->user?->nombre, $catedratico->user?->apellido_paterno, $catedratico->user?->apellido_materno])))
            : 'Catedrático no encontrado';
        //Obtenemos el nombre de la carrera y se lo asignamos a la variable
        $data->car_Nombre = CarrerasSitService::nombreDeArea($data->car_Clave);
        //Abrimos el editor de PDF y le enviamos la vista que diseñamos para la impresión              
        return PDF::loadView('sta.tutorias.libTutPDF', compact('data'))
        ->setPaper('letter', 'portrait')
        ->stream('Liberación de tutoria.pdf');
    }

    
   
}
