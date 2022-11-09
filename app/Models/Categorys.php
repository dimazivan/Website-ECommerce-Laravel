<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorys extends Model
{
    use HasFactory;
    protected $table = "categorys";
    protected $fillable = [
       'umkms_id',
       'name',
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
