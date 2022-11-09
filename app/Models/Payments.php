<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $fillable = [
       'umkms_id',
       'name',
       'name_account',
       'type',
       'number',
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
