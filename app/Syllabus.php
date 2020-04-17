<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    public $fillable=[
        'Title','Description','Subject','Class','UploadedBy','File'
    ];
}
