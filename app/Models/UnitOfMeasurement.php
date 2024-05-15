<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOfMeasurement extends Model
{
    use UuidTrait, ActorTrait, SoftDeletes;

    protected $guarded = [];
}
