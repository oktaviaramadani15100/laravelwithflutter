<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    // protected $table = 'payments'; 

    protected $fillable = [
        'order_id',
        'status',
        'price',
        'item_name',
        'customer_firts_name',
        'customer_email',
        'checkout_link'
    ];
}
