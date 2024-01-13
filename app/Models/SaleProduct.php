<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'sales_id',
        'currency_id',
        'currency_optimal_id',
        'currencyoptimal_amount',
        'count',
        'total',
        'soft_delete'
    ];
}
