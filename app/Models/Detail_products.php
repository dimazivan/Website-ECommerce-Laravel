<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_products extends Model
{
    use HasFactory;
    protected $table = "detail_products";
    protected $fillable = [
       'products_id',
       'color',
       'modal',
       'price',
       'promo',
       'size',
       'qty',
    ];

    public function products()
    {
        return $this->belongsTo('App\Models\Products');
    }

    public function detail_orders()
    {
        return $this->hasMany('App\Models\Detail_orders');
    }
}
