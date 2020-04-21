<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\{ToModel};
use Maatwebsite\Excel\Concerns\{WithHeadingRow};

class StudentsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Student([
            'StudentName'  =>  $row['studentname'],
            'parent'  =>  $row['studentparent'],
            'class'  =>  $row['class'],
            'Stream'  =>  $row['stream'],
            'AdmissionNumber'  =>  $row['admissionnumber'],
            'Kcpe'  =>  $row['kcpe'],
            'birthDate'  =>  $row['dateofbirth'],
            'Passport'  =>  $row['passport'],
            'Nemis'  =>  $row['nemis'],
            'SchoolFees'  =>  $row['schoolfees'],
            'Balance'  =>  $row['balance'],
            'Status'  =>  0
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
