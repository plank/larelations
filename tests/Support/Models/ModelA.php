<?php

namespace Plank\Larelations\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Plank\Larelations\Tests\Support\Traits\ProblematicMethods;

class ModelA extends Model
{
    use ProblematicMethods;

    public function hasOneWithReturnType(): HasOne
    {
        return $this->hasOne(ModelB::class);
    }

    public function hasOneWithoutReturnType()
    {
        return $this->hasOne(ModelB::class);
    }

    public function hasOneThroughWithReturnType(): HasOneThrough
    {
        return $this->hasOneThrough(ModelC::class, ModelB::class);
    }

    public function hasOneThroughWithoutReturnType()
    {
        return $this->hasOneThrough(ModelC::class, ModelB::class);
    }

    public function hasManyWithReturnType(): HasMany
    {
        return $this->hasMany(ModelB::class);
    }

    public function hasManyWithoutReturnType()
    {
        return $this->hasMany(ModelB::class);
    }

    public function hasManyThroughWithReturnType(): HasManyThrough
    {
        return $this->hasManyThrough(ModelC::class, ModelB::class);
    }

    public function hasManyThroughWithoutReturnType()
    {
        return $this->hasManyThrough(ModelC::class, ModelB::class);
    }

    public function belongsToManyWithReturnType(): BelongsToMany
    {
        return $this->belongsToMany(ModelC::class);
    }

    public function belongsToManyWithoutReturnType()
    {
        return $this->belongsToMany(ModelC::class);
    }

    public function morphOneWithReturnType(): MorphOne
    {
        return $this->morphOne(ModelB::class, 'morphable');
    }

    public function morphOneWithoutReturnType()
    {
        return $this->morphOne(ModelB::class, 'morphable');
    }

    public function morphManyWithReturnType(): MorphMany
    {
        return $this->morphMany(ModelB::class, 'morphable');
    }

    public function morphManyWithoutReturnType()
    {
        return $this->morphMany(ModelB::class, 'morphable');
    }
}
