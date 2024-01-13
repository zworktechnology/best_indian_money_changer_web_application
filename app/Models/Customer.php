<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'name',
        'phone_number',
        'note',
        'current_balance',
        'soft_delete'
    ];
}
