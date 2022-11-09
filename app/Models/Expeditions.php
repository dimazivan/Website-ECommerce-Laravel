<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expeditions extends Model
{
    use HasFactory;
    protected $table = "expeditions";
    protected $fillable = [
       'umkms_id',
       'name',
       'type',
       'price',
       'phone'
    ];
    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
