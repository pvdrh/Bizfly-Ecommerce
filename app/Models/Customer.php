<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'age',
        'address',
        'company_id',
        'job',
        'customer_type',
        'user_id'
    ];

    public function orders()
    {
        $this->hasMany(Order::class);
    }

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
