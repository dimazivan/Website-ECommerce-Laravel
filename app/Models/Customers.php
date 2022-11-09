<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = "customers";
    protected $fillable = [
       'users_id',
       'first_name',
       'last_name',
       'address',
       'districts',
       'ward',
       'city',
       'province',
       'postal_code',
       'phone',
       'desc',
    ];

    public function users()
    {
        return $this->belongsto('App\Models\Users');
    }
}
