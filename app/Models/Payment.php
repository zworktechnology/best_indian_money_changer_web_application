<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'total_paid',
        'total_balance',
        'purchase_customerid',
        'purchase_amount',
        'purchase_paid',
        'purchase_balance'
    ];
}
