<?php

namespace App\Imports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading; //Para cargar la hoja de excel por partes a la memoria

class AlumnosImport implements ToModel
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
           'password' => bcrypt($row[3]),
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










