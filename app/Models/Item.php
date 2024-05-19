<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use UuidTrait, ActorTrait, SoftDeletes;

    protected $guarded = [];

    public function getThumbnailFullUrlAttribute(): string
    {
        if ($this->thumbnail_url && Storage::disk('public')->exists($this->thumbnail_url)) {
            return asset('storage/' . $this->thumbnail_url);
        }

        return '';
    }

    public function itemCategories(): BelongsToMany
    {
        return $this->belongsToMany(ItemCategory::class);
    }

    public function itemDetails(): HasMany
    {
        return $this->hasMany(ItemDetail::class);
    }

    public function itemCodes(): HasMany
    {
        return $this->hasMany(ItemCode::class);
    }
}
