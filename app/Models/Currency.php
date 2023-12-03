<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'code',
        'name',
        'country',
        'description',
        'soft_delete'
    ];

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'currency_id');
    }
    public function sale()
    {
        return $this->hasMany(Sale::class, 'currency_id');
    }
}
