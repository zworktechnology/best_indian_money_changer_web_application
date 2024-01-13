<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyOptimal extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'available_stock',
        'soft_delete'
    ];
}
