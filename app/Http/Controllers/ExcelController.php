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
          
          // Obtener el archivo y su extensión
          $file = $request->file('excel');
          $extension = strtolower($file->getClientOriginalExtension());
          
          // Determinar el tipo de archivo explícitamente
          $fileType = null;
          switch ($extension) {
              case 'xlsx':
                  $fileType = \Maatwebsite\Excel\Excel::XLSX;
                  break;
              case 'xls':
                  $fileType = \Maatwebsite\Excel\Excel::XLS;
                  break;
              case 'csv':
                  $fileType = \Maatwebsite\Excel\Excel::CSV;
                  break;
              default:
                  throw new \Exception("Formato de archivo no soportado: {$extension}");
          }
          
          // Importar especificando el tipo de archivo
          $array = Excel::toArray(new AlumnosImport, $file->getPathname(), null, $fileType);
          
          if ($array && count($array[0]) > 0) 
          {          
              $contador = 0;
              foreach ($array[0] as $row)       
              {                     
                  $actualizados = Alumno::where('no_control', $row[2])->update(['password' => bcrypt($row[3])]);
                  if ($actualizados) {
                      $contador++;
                  }
              }            
              
              Alert::success('Correcto', "Se actualizaron {$contador} contraseñas exitosamente");
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








