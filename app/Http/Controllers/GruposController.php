<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use Illuminate\Support\Facades\DB;
use Alert;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getGrupos(Request $request)
    {
        //Obtenemos los grupos de la base de datos
        $grupos = Grupo::where('id_Carrera',$request->car_Clave)
        ->where('status',0)
        ->get();
        //Retornamos los grupos en json
        return response()->json($grupos);
    }

    //Función que debuelve todos los grupos creados
    public function indexGrupos()
    {
        //Obtenemos los grupos de la base de datos
        $grupos = Grupo::all();

        //Obtenemos las carreras de la base de datos
        $carreras = DB::connection('contEsc')->table('carreras')
        ->where('car_Status','VIGENTE')
        ->get();
        
        //Agregamos el nombre de la carrera a cada grupo
        foreach ($grupos as $grupo) {
            $grupo->carrera = DB::connection('contEsc')->table('carreras')
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
            ['id_Carrera' => $request->id_Carrera, 'status' =>0]
        );       
        
        if ($grupo->wasRecentlyCreated) {
            // El grupo no existía y se creó
            Alert::success('Correcto',"El grupo se ha creado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.indexGrupos');                    
        } 
        else {
            // El usuario ya existía y se actualizó
            Alert::success('Correcto',"El grupo se ha actualizado correctamente");
            //Regresamos a la vista de grupos
            return redirect()->route('tutorias.indexGrupos');
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
        return redirect()->route('tutorias.indexGrupos');
    }

    //Función para modificar un grupo
    public function updateGrupo(Request $request, $id)
    {
        //Obtenemos el grupo a modificar
        $grupo = Grupo::find($id); 
        //Actualizamos el grupo
        $grupo->gpo_Nombre = $request->gpo_Nombre;
        $grupo->id_Carrera = $request->id_Carrera;
        $grupo->status = $request->status;
        $grupo->save();
        Alert::success('Correcto',"El grupo se ha actualizado correctamente");
        //Regresamos a la vista de grupos
        return redirect()->route('tutorias.indexGrupos');
    }
   
}
