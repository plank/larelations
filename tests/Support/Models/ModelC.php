<?php

namespace Plank\Larelations\Tests\Support\Models;

use Illuminate\Contracts\Database\Eloquent\SupportsPartialRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Plank\Larelations\Tests\Support\Contracts\ContractOne;
use Plank\Larelations\Tests\Support\Contracts\ContractTwo;
use Plank\Larelations\Tests\Support\Traits\ProblematicMethods;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class ModelC extends Model implements ContractOne, ContractTwo
{
    use BelongsToThroughTrait;
    use ProblematicMethods;

    public function relationIntersectionReturnType(): SupportsPartialRelations&MorphOne
    {
        return $this->morphOne(ModelB::class, 'morphable');
    }

    public function relationUnionReturnType(): BelongsTo|HasOne
    {
        return $this->belongsTo(ModelB::class);
    }

    public function belongsToThroughWithoutReturnType()
    {
        return $this->belongsToThrough(ModelA::class, ModelB::class);
    }

    public function belongsToThroughWithReturnType(): BelongsToThrough
    {
        return $this->belongsToThrough(ModelA::class, ModelB::class);
    }
}
