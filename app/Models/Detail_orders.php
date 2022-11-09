<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_orders extends Model
{
    use HasFactory;
    protected $table = "detail_orders";
    protected $fillable = [
       'orders_id',
       'umkms_id',
       'products_id',
       'detail_products_id',
       'products_name',
       'category',
       'size',
       'color',
       'qty',
       'price',
       'subtotal',
    ];

    public function orders()
    {
        return $this->belongsto('App\Models\Orders');
    }

    public function products()
    {
        return $this->belongsto('App\Models\Products');
    }

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }

    public function productions()
    {
        return $this->hasOne('App\Models\Productions');
    }
}
