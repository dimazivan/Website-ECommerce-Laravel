<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback_customs extends Model
{
    use HasFactory;
    protected $table = "feedback_customs";
    protected $fillable = [
       'umkms_id',
       'customs_id',
       'rating',
       'desc',
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
