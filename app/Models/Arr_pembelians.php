<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arr_pembelians extends Model
{
    use HasFactory;
    protected $table = "arr_pembelians";
    protected $fillable = [
       'umkms_id',
       'users_id',
       'suppliers_id',
       'name_material',
       'date',
       'qty',
       'price',
       'subtotal',
       'tgl_pengiriman',
       'tgl_penerimaan',
    ];
}
