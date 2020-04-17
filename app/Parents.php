<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    public $fillable=[
        'Names',
        'Email',
        'Gender',
        'AcademicLevel',
        'Disabled',
        'PhoneNumber',
        'Nationality',
        'Passport',
        'PostalAddress'
    ];
}
