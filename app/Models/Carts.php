<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $table = "cart";
    protected $fillable = [
       'umkms_id',
       'users_id',
       'promos_id',
       'products_id',
       'detail_products_id',
       'products_name',
       'color',
       'category',
       'size',
       'qty',
       'price',
       'subtotal',
       'date',
    ];
}
