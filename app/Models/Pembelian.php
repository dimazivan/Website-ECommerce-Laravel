<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = "pembelians";
    protected $fillable = [
       'umkms_id',
       'users_id',
       'date',
       'total',
    //    'pict_payment',
    //    'status',
    //    'keterangan',
    //    'shipping',
    //    'ongkir'
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }

    public function users()
    {
        return $this->belongsto('App\Models\Users');
    }
}
