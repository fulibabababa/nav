<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeOther($query)
    {
        return $query->where(['type' => null]);
    }

    public function scopeNotInBlackList($query)
    {
        return $query->where('status', '>=', 0);
    }
}
