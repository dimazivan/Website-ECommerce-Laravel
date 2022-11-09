<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback_orders extends Model
{
    use HasFactory;
    protected $table = "feedback_orders";
    protected $fillable = [
       'umkms_id',
       'orders_id',
       'rating',
       'desc',
    ];

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
