<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteHead extends Model
{
    public $fillable=[
        'VoteHead',
        'Class',
        'Status'
    ];
}
