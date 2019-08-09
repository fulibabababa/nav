<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use James\Sortable\SortableTrait;

class Link extends Model
{
    const STATUS_BLACKLIST = -1;
    const STATUS_PENDING   = 0;
    const STATUS_SUCCESS   = 1;

    use SortableTrait;

    static public $statusMap = [
        self::STATUS_BLACKLIST => '黑名单',
        self::STATUS_PENDING   => '等待收录',
        self::STATUS_SUCCESS   => '已收录',
    ];

    protected $guarded = [];

    public $sortable = [
        'sort_field'         => 'rank',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];

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
