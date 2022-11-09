<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimations extends Model
{
    use HasFactory;
    protected $table = "estimations";
    protected $fillable = [
        'umkms_id',
        'name_process',
        'urutan',
        'durasi',
    ];
    
    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
