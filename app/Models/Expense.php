<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'date',
        'time',
        'amount',
        'description',
        'soft_delete'
    ];
}
