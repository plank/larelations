<?php

namespace Plank\Larelations\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Larelations\Tests\Support\Traits\ProblematicMethods;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class ModelC extends Model
{
    use BelongsToThroughTrait;
    use ProblematicMethods;

    public function belongsToThroughWithoutReturnType()
    {
        return $this->belongsToThrough(ModelA::class, ModelB::class);
    }

    public function belongsToThroughWithReturnType(): BelongsToThrough
    {
        return $this->belongsToThrough(ModelA::class, ModelB::class);
    }
}
