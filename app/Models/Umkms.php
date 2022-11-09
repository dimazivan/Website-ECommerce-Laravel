<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkms extends Model
{
    use HasFactory;

    protected $table = "umkms";

    protected $fillable = [
        'owner_name',
        'umkm_name',
        'location',
        'districts',
        'ward',
        'city',
        'province',
        'postal_code',
        'phone',
        'open_time',
        'close_time',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\Users');
    }

    public function banner()
    {
        return $this->hasMany('App\Models\Banner');
    }

    public function categorys()
    {
        return $this->hasMany('App\Models\Categorys');
    }

    public function colors()
    {
        return $this->hasMany('App\Models\Colors');
    }

    public function expeditions()
    {
        return $this->hasMany('App\Models\Expeditions');
    }

    public function info()
    {
        return $this->hasMany('App\Models\Info');
    }

    public function materials()
    {
        return $this->hasMany('App\Models\Materials');
    }

    public function detail_orders()
    {
        return $this->hasMany('App\Models\Detail_orders');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payments');
    }

    public function pembelian()
    {
        return $this->hasMany('App\Models\Pembelian');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products');
    }

    public function promo()
    {
        return $this->hasMany('App\Models\Promo');
    }

    public function suppliers()
    {
        return $this->hasMany('App\Models\Suppliers');
    }

    public function productions()
    {
        return $this->hasOne('App\Models\Productions');
    }

    public function production_customs()
    {
        return $this->hasOne('App\Models\Production_customs');
    }

    public function feedback_orders()
    {
        return $this->hasOne('App\Models\Feedback_orders');
    }

    public function feedback_customs()
    {
        return $this->hasOne('App\Models\Feedback_customs');
    }

    public function deadlines()
    {
        return $this->hasOne('App\Models\Deadlines');
    }
}
