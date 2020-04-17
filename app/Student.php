<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $fillable=[
        'StudentName',
        'parent',
        'class',
        'Stream',
        'AdmissionNumber',
        'Kcpe',
        'birthDate',
        'Passport',
        'Nemis',
        'Status'
    ];
}
