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
        'time',
        'currency_id',
        'purchases_count',
        'purchases_count_per_price',
        'total',
        'description',
        'soft_delete'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
