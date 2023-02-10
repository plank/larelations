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
        return $this->relation instanceof HasOne
            || $this->relation instanceof HasMany
            || $this->relation instanceof HasManyThrough
            || $this->relation instanceof MorphOne
            || $this->relation instanceof HasOneThrough
            || $this->relation instanceof MorphMany;
    }

    public function isParent()
    {
        return $this->relation instanceof BelongsTo
            || $this->relation instanceof MorphTo;
    }

    public function isPivot()
    {
        return in_array(InteractsWithPivotTable::class, class_uses_recursive($this->relation));
    }

    public function isThrough()
    {
        return $this->relation instanceof HasManyThrough
            || $this->relation instanceof HasOneThrough;
    }

    public function isPolymorphic()
    {
        return (property_exists($this->relation, 'morphType')
            && property_exists($this->relation, 'morphClass'))
            || property_exists($this->relation, 'morphType');
    }
}
