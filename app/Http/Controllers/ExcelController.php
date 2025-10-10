<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
          // Validar que se subió un archivo
          $request->validate([
              'excel' => 'required|file|mimes:xlsx,xls,csv'
          ]);

          ini_set('max_execution_time', 0);
          
          // Usar el archivo directamente sin obtener el path
          $array = Excel::toArray(new AlumnosImport, $request->file('excel'));
          
          if ($array && count($array[0]) > 0) 
          {          
              $contador = 0;
              $errores = 0;
              
              foreach ($array[0] as $index => $row)       
              {       
                  // Validar que la fila tenga las columnas necesarias (1 y 2)
                  // $row[1] = no_control, $row[2] = password
                  if (isset($row[1]) && isset($row[2]) && !empty($row[1]) && !empty($row[2])) {
                      $actualizados = Alumno::where('no_control', $row[1])->update(['password' => bcrypt($row[2])]);
                      if ($actualizados) {
                          $contador++;
                      }
                  } else {
                      $errores++;
                      \Log::warning("Fila {$index} no tiene datos válidos - NoControl: " . ($row[1] ?? 'VACIO') . ", Password: " . ($row[2] ?? 'VACIO'));
                  }
              }            
              
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
        \Log::error('Error en importClaves: ' . $e->getMessage());
        \Log::error('File: ' . $e->getFile());
        \Log::error('Line: ' . $e->getLine());
        
        Alert::error('Error', 'Ocurrio un error durante la actualización: ' . $e->getMessage());
        return back()->withInput();
      }
  }

}








