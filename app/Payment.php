<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable=[
        'PaymentCode',
        'StudentAdmission',
        'Amount',
        'PaymentMethod',
        'PaidBy',
        'ReceivedBy',
        'Status'
    ];
}
