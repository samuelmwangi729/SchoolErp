<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable=[
        'StudentAdmission',
        'Amount',
        'PaymentMethod',
        'Status'
    ];
}
