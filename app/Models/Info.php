<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;
    protected $table = "infos";
    protected $fillable = [
        'umkms_id',
        'no_wa',
        'title',
        'alamat',
        'link_tokped',
        'link_shopee',
        'link_email',
        'link_instagram',
        'description_login',
        'description_register',
        'description_umkm',
        'description_product',
        'description_detail',
        'description_lainnya',
        'date',
    ];
    
    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
