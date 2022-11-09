<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
       'users_id',
       'promos_id',
       'first_name',
       'last_name',
       'phone',
       'postal_code',
       'address',
       'districts',
       'ward',
       'city',
       'province',
       'desc',
       'date',
       'tgl_pengiriman',
       'status',
       'potongan',
       'total',
       'status_payment',
       'keterangan',
       'shipping',
       'status_shipping',
       'ongkir',
    ];

    public function users()
    {
        return $this->belongsto('App\Models\Users');
    }

    // public function promo()
    // {
    //     return $this->belongsto('App\Models\Promo');
    // }

    public function detail_orders()
    {
        return $this->hasMany('App\Models\Detail_orders');
    }

    public function productions()
    {
        return $this->hasMany('App\Models\Productions');
    }
}
