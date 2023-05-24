<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;

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
        //Retornamos los grupos en json 
        return response()->json($grupos);
    }

    //Función para guardar los grupos con el modelo Grupo
    public function saveGrupo(Request $request)
    {
        //Guarda el grupo si no existe en la tabla de grupos
        $grupo=Grupo::updateOrCreate(
            ['gpo_Nombre' => $request->gpo_Nombre],
            ['id_Carrera' => $request->car_Clave, 'status' =>0]
        );       
        
        if ($grupo->wasRecentlyCreated) {
            // El usuario fue creado (es decir, se insertó un nuevo registro)  
            // Prepara los datos de respuesta
            $data = [
                'message' => 'El grupo se guardó correctamente'                
            ];
            // Retorna la respuesta como un objeto JSON con código de estado 200
            return response()->json($data, 200);           
        } 
        else {
            // El usuario ya existía y se actualizó
            // Prepara los datos de respuesta
            $data = [
                'message' => 'El grupo ya existe'                
            ];
            // Retorna la respuesta como un objeto JSON con código de estado 500    
            return response()->json($data, 500);
        }

        
    }
   
}
