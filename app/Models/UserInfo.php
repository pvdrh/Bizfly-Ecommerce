<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    const ROLE = [
        'admin' => 0,
        'employee' => 1,
    ];

    protected $fillable = [
        'name',
        'phone',
        'address',
        'gender',
        'user_id',
        'role',
        'is_protected',
        'code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
