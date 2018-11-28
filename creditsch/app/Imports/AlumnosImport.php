<?php

namespace App\Imports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading; //Para cargar la hoja de excel por partes a la memoria

class AlumnosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Alumno([
           'no_control'     => $row[2],
           'password' => bcrypt($row[3]),
        ]);
     
    }

    public function chunkSize(): int
    {
        return 1000;//Cantidad de registros que se cargan a la memoria de forma simultanea.
    }
}





