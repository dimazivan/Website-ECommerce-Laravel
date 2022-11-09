<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $table = "suppliers";
    protected $fillable = [
       'umkms_id',
       'name',
       'address',
       'email',
       'phone',
    ];

    public function materials()
    {
        return $this->hasOne('App\Models\Materials');
    }

    public function detail_pembelian()
    {
        return $this->hasMany('App\Models\Detail_pembelian');
    }

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
