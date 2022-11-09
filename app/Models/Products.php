<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
       'umkms_id',
       'name',
       'category',
       'desc',
       'pict_1',
       'pict_2',
       'pict_3',
    ];

    public function detail_products()
    {
        return $this->hasMany('App\Models\Detail_products');
    }

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
