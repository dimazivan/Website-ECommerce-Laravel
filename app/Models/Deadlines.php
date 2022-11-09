<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadlines extends Model
{
    use HasFactory;
    protected $table = "deadlines";
    protected $fillable = [
       'umkms_id',
       'deadline',
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
