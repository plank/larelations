<?php

namespace Plank\Larelations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionMethod;

class RelationInstance
{
    public function __construct(
        public readonly ReflectionMethod $method,
        public readonly Relation $relation
    ) {
    }

    public function isChild()
    {
        return is_a($this->relation, HasOne::class)
            || is_a($this->relation, HasMany::class)
            || is_a($this->relation, HasManyThrough::class)
            || is_a($this->relation, MorphOne::class)
            || is_a($this->relation, HasOneThrough::class)
            || is_a($this->relation, MorphMany::class);
    }

    public function isParent()
    {
        return is_a($this->relation, BelongsTo::class)
            || is_a($this->relation, MorphTo::class);
    }

    public function isPivot()
    {
        return in_array(InteractsWithPivotTable::class, class_uses_recursive($this->relation));
    }

    public function isThrough()
    {
        return is_a($this->relation, HasManyThrough::class)
            || is_a($this->relation, HasOneThrough::class);
    }

    public function isPolymorphic()
    {
        return (property_exists($this->relation, 'morphType')
            && property_exists($this->relation, 'morphClass'))
            || property_exists($this->relation, 'morphType');
    }
}
