<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use Alert;



class ExcelController extends Controller
{
   
  public function index(Request $request)
  {     
    return view('admin.ImportExcel.index');
  }

  public function importClaves(Request $request)
  {      
      try{
          $request->validate([
              'excel' => 'required|file|mimes:xlsx,xls,csv'
          ]);

          ini_set('max_execution_time', 0);
          ini_set('memory_limit', '512M');
          
          $array = Excel::toArray(new AlumnosImport, $request->file('excel'));
          
          if ($array && count($array[0]) > 0) 
          {          
              $contador = 0;
              $errores = 0;
              
              // Usar transacción para mayor velocidad
              DB::beginTransaction();
              
              foreach ($array[0] as $index => $row)       
              {       
                  if (isset($row[1]) && isset($row[2]) && !empty($row[1]) && !empty($row[2])) {
                      // Usar update directo sin Eloquent para mayor velocidad
                      $actualizados = DB::table('alumnos')
                                      ->where('no_control', $row[1])
                                      ->update(['password' => bcrypt($row[2])]);
                      
                      if ($actualizados) {
                          $contador++;
                      }
                  } else {
                      $errores++;
                  }
              }
              
              DB::commit();
              
              $mensaje = "Se actualizaron {$contador} contraseñas exitosamente";
              if ($errores > 0) {
                  $mensaje .= ". {$errores} filas tenían datos incompletos";
              }
              
              Alert::success('Correcto', $mensaje);
              return redirect()->route('ImportExcel.index');           
          } else {
              Alert::warning('Advertencia', 'El archivo está vacío o no tiene datos válidos');
              return back()->withInput();
          }
      } 
      catch (\Exception $e)
      {    
          DB::rollBack();
          \Log::error('Error en importClaves: ' . $e->getMessage());
        
          Alert::error('Error', 'Ocurrio un error durante la actualización: ' . $e->getMessage());
          return back()->withInput();
      }
  }
  

}








