<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    use HasFactory;
    protected $table = "materials";
    protected $fillable = [
       'umkms_id',
       'suppliers_id',
       'name',
       'price',
       'qty',
    ];

    public function suppliers()
    {
        return $this->belongsTo('App\Models\Suppliers');
    }

    public function umkms()
    {
        return $this->belongsto('App\Models\Umkms');
    }
}
