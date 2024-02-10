<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'purchase_id',
        'currency_id',
        'currency_optimal_id',
        'currencyoptimal_amount',
        'count',
        'total',
        'soft_delete'
    ];
}
