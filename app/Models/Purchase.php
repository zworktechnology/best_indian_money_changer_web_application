<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'date',
        'billno',
        'time',
        'currency_id',
        'customer_id',
        'grand_total',
        'purchasebalancetype',
        'oldbalanceamount',
        'overallamount',
        'paid_amount',
        'balance_amount',
        'note',
        'soft_delete'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
