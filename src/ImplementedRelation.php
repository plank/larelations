<?php

namespace Plank\Larelations;

use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionMethod;

class ImplementedRelation
{
    public function __construct(
        public ReflectionMethod $method,
        public Relation $relation
    ) {
    }
}
