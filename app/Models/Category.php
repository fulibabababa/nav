<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use James\Sortable\SortableTrait;

class Category extends Model
{
    const ONLINE  = 1;
    const OFFLINE = 0;

    const CAN_REGISTER  = 1;
    const CANNOT_REGISTER = 0;

    use SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'sort_field'         => 'rank',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];

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
