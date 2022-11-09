<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pembelians extends Model
{
    use HasFactory;
    protected $table = "detail_pembelians";
    protected $fillable = [
       'pembelians_id',
       'suppliers_id',
       'name_material',
       'qty',
       'price',
       'subtotal',
       'tgl_pengiriman',
       'tgl_penerimaan',
    ];

    public function suppliers()
    {
        return $this->belongsto('App\Models\Suppliers');
    }

    public function pembelians()
    {
        return $this->belongsto('App\Models\Pembelian');
    }
}
