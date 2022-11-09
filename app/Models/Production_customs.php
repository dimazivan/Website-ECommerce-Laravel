<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production_customs extends Model
{
    use HasFactory;
    protected $table = "production_customs";
    protected $fillable = [
       'umkms_id',
       'users_id',
       'customs_id',
       'qty',
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

    public function customs()
    {
        return $this->belongsto('App\Models\Customs');
    }
}
