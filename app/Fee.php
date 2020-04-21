<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    public $fillable=[
        'Class',
        'VoteHead',
        'Term',
        'Amount',
        'Year'
    ];
}
