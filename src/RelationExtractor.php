<?php

namespace Plank\Larelations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

class RelationExtractor
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
            ->filter(function (ReflectionMethod $method) {
                if (! $method->isPublic() || $method->isStatic()) {
                    return false;
                }

                if (count($method->getParameters())) {
                    return false;
                }

                if ($method->class === Model::class) {
                    return false;
                }

                if ($returnType = $method->getReturnType()) {
                    return is_a($returnType->getName(), Relation::class, true);
                }

                return true;
            })
            ->map(function (ReflectionMethod $method) use ($model) {
                try {
                    $relation = @$model->{$method->getName()}();
                } catch (\Exception $e) {
                    return null;
                }

                if ($relation instanceof Relation) {
                    return new ImplementedRelation($method, $relation);
                }

                return null;
            })
            ->filter()
            ->values();
    }
}
