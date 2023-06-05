<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use Illuminate\Support\Facades\DB;
use App\Models\AsignacionTutores;
use Alert;

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
        //Obtenemos las carreras de la base de datos
        $carreras = DB::connection('contEsc')->table('carreras')
        ->where('car_Status','VIGENTE')
        ->get();        
        //Agregamos el nombre de la carrera a cada grupo
        foreach ($grupos as $grupo) {
            $grupo->gpo_Carrera = DB::connection('contEsc')->table('carreras')
            ->where('car_Clave',$grupo->id_Carrera)
            ->first()->car_Nombre;
        }
        //Retornamos la vista de grupos con los grupos obtenidos
        return view('sta.tutorias.grupos',compact('grupos','carreras'));
    }

    //Función para guardar los grupos con el modelo Grupo
    public function saveGrupo(Request $request)
    { 
        //Guarda el grupo si no existe en la tabla de grupos
        $grupo=Grupo::updateOrCreate(
            ['gpo_Nombre' => $request->gpo_Nombre],
            ['gpo_Semestre' => $request->gpo_Semestre, 'id_Carrera' => $request->id_Carrera, 'gpo_Status' => 0]
        );         
        if ($grupo->wasRecentlyCreated) {
            // El grupo no existía y se creó
            Alert::success('Correcto',"El grupo se ha creado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.getGruposAll');                    
        } 
        else {
            // El usuario ya existía y se actualizó
            Alert::success('Correcto',"El grupo se ha actualizado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.getGruposAll');
        }        
    }

    //Función para eliminar un grupo    
    public function deleteGrupo($id)
    {
        //Obtenemos el grupo a eliminar
        $grupo = Grupo::find($id);
        //Eliminamos el grupo
        $grupo->delete();
        Alert::success('Correcto',"El grupo se ha eliminado correctamente");
        //Regresamos a la vista de grupos
        return redirect()->route('tutorias.getGruposAll');
    }

    //Función para modificar un grupo
    public function updateGrupo(Request $request, $id)
    {   
        //Obtenemos el grupo a modificar
        $grupo = Grupo::find($id); 
        //Actualizamos el grupo
        $grupo->gpo_Nombre = $request->gpo_Nombre;
        $grupo->id_Carrera = $request->id_Carrera;
        $grupo->gpo_Status = $request->gpo_Status;
        $grupo->gpo_Semestre= $request->gpo_Semestre;
        $grupo->save();
        Alert::success('Correcto',"El grupo se ha actualizado correctamente");
        //Regresamos a la vista de grupos
        return redirect()->route('tutorias.getGruposAll');
    }

    //Funcion para guardar los grupos de tutorias
    public function saveGrupoTut(Request $request)
    {    
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
            Alert::success('Correcto',"El grupo se ha eliminado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');
        } catch (\Throwable $th) {
            Alert::error('Error',"Ocurrio un error al eliminar el grupo");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.index');
        }       
    }

    
   
}
