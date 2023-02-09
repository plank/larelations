<?php

namespace Plank\Larelations\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Plank\Larelations\Tests\Support\Traits\ProblematicMethods;

class ModelB extends Model
{
    use ProblematicMethods;

    public function belongsToWithReturnType(): BelongsTo
    {
        return $this->belongsTo(ModelA::class);
    }

    public function belongsToWithoutReturnType()
    {
        return $this->belongsTo(ModelA::class);
    }

    public function morphToWithReturnType(): MorphTo
    {
        return $this->morphTo(ModelA::class, 'morphable');
    }

    public function morphToWithoutReturnType()
    {
        return $this->morphTo(ModelA::class, 'morphable');
    }

    public function morphToManyWithReturnType(): MorphToMany
    {
        return $this->morphedByMany(ModelA::class, 'morphable');
    }

    public function morphToManyWithoutReturnType()
    {
        return $this->morphedByMany(ModelA::class, 'morphable');
    }
}
