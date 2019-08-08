<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const ONLINE  = 1;
    const OFFLINE = 0;

    const CAN_REGISTER  = 1;
    const CANNOT_REGISTER = 0;

    protected $guarded = [];

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCanRegister($query, $can)
    {
        return $query->where('can_register', $can);
    }
}
