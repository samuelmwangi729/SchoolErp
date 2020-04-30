<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public $fillable=[
        'Exam','Term','Class','Year','Status'
    ];
}
