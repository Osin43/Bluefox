<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'status',
        'qualtity',
        'discount',
        'total',
        'price',
        'payment',
        'user_id',
        
    ];
}
