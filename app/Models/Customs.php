<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customs extends Model
{
    use HasFactory;
    protected $table = "customs";
    protected $fillable = [
       'users_id',
       'umkms_id',
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
       'qty',
       'subtotal',
       'potongan',
       'total',
       'status',
       'pict_desain_depan',
       'pict_desain_belakang',
       'pict_payment',
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

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }

    public function production_customs()
    {
        return $this->hasOne('App\Models\Production_customs');
    }
}
