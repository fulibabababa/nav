<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    const STATUS_BLACKLIST = -1;
    const STATUS_PENDING   = 0;
    const STATUS_SUCCESS   = 1;

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
        return $query->where('status', '>=', self::STATUS_PENDING);
    }

    public function scopeInPending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeInSuccess($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    public function isOverMaxFailure()
    {
        return $this->failure_times >= config('protect.max_failure_times');
    }
}
