<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    protected $table = "promos";
    protected $fillable = [
       'umkms_id',
       'name',
       'kode',
       'type',
       'jumlah',
       'create_date',
       'status',
    ];

    // public function orders()
    // {
    //     return $this->hasMany('App\Models\Orders');
    // }

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
