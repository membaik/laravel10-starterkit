<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use UuidTrait, ActorTrait, SoftDeletes;

    protected $guarded = [];

    public function itemCategories(): BelongsToMany
    {
        return $this->belongsToMany(ItemCategory::class);
    }
}
