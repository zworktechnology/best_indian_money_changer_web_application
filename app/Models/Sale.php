<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'date',
        'time',
        'currency_id',
        'sales_count',
        'sales_count_per_price',
        'total',
        'description',
        'soft_delete'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
