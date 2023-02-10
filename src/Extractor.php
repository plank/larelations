<?php

namespace Plank\Larelations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;

class Extractor
{
    /**
     * @param  Model|class-string<Model>  $model
     * @return Collection<ImplementedRelation>
     */
    public function extract(Model|string $model): Collection
    {
        $model = is_string($model) ? new $model : $model;
        $class = new ReflectionClass($model);

        return (new Collection($class->getMethods()))
            ->filter(fn (ReflectionMethod $method) => $this->hasRelationSignature($method))
            ->map(fn (ReflectionMethod $method) => $this->toImplementedRelation($model, $method))
            ->filter()
            ->values();
    }

    protected function hasRelationSignature(ReflectionMethod $method): bool
    {
        if (! $method->isPublic()
            || $method->isStatic()
            || count($method->getParameters())
            || $method->class === Model::class
        ) {
            return false;
        }

        if ($returnType = $method->getReturnType()) {
            return $this->returnsRelation($returnType);
        }

        return true;
    }

    protected function returnsRelation(ReflectionType $returnType): bool
    {
        switch (get_class($returnType)) {
            case ReflectionUnionType::class:
                return $this->unionReturnIsRelation($returnType);

            case ReflectionIntersectionType::class:
                return $this->intersectionReturnIsRelation($returnType);

            default:
                return $this->namedReturnIsRelation($returnType);
        }
    }

    protected function unionReturnIsRelation(ReflectionUnionType $returnType): bool
    {
        foreach ($returnType->getTypes() as $union) {
            if (! $this->namedReturnIsRelation($union)) {
                return false;
            }
        }

        return true;
    }

    protected function intersectionReturnIsRelation(ReflectionIntersectionType $returnType): bool
    {
        foreach ($returnType->getTypes() as $union) {
            if ($this->namedReturnIsRelation($union)) {
                return true;
            }
        }

        return false;
    }

    protected function namedReturnIsRelation(ReflectionNamedType $returnType): bool
    {
        return is_a($returnType->getName(), Relation::class, true);
    }

    protected function toImplementedRelation(Model $model, ReflectionMethod $method): ?ImplementedRelation
    {
        try {
            $relation = @$model->{$method->getName()}();
        } catch (\Exception $e) {
            return null;
        }

        if ($relation instanceof Relation) {
            return new ImplementedRelation($method, $relation);
        }

        return null;
    }
}
