<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productions extends Model
{
    use HasFactory;
    protected $table = "productions";
    protected $fillable = [
       'umkms_id',
       'users_id',
       'detail_orders_id',
       'products_name',
       'category',
       'qty',
       'size',
       'color',
       'status',
       'status_produksi',
       'estimasi',
       'tanggal_mulai',
       'tanggal_selesai',
    ];
    
    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }

    public function users()
    {
        return $this->belongsto('App\Models\Users');
    }

    public function detail_orders()
    {
        return $this->belongsto('App\Models\Detail_orders');
    }
}
