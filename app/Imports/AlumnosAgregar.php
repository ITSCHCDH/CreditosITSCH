<?php

namespace App\Imports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading; //Para cargar la hoja de excel por partes a la memoria

class AlumnosAgregar implements ToModel
{
    
    public function model(array $row)
    {
        /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
        
       return new alumno([
           'no_control' => $row[2],
           'nombre'=>$rows[3],
           'password' => bcrypt($row[4]),
           'carrera'=>$rows[6]
        ]);       
     
    }

     public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

  
}