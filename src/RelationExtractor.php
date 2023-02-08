<?php

namespace Plank\Larelations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;
use SplFileObject;

class RelationExtractor
{
    /**
     * @var array<class-string<Relation>>
     */
    protected $relations = [
        BelongsTo::class,
        BelongsToMany::class,
        HasMany::class,
        HasManyThrough::class,
        HasOne::class,
        HasOneOrMany::class,
        HasOneThrough::class,
        MorphMany::class,
        MorphOne::class,
        MorphOneOrMany::class,
        MorphPivot::class,
        MorphTo::class,
        MorphToMany::class,
    ];

    /**
     * @param  class-string<Relation>  $relation
     */
    public function addRelation(string $relation): void
    {
        $this->relations[] = $relation;
    }

    /**
     * @param  array<class-string<Relation>>  $relations
     */
    public function addRelations(array $relations): void
    {
        $this->relations = array_merge($this->relations, $relations);
    }

    /**
     * @param  Model|class-string<Model>  $model
     * @return array<Relation>
     */
    public function extract(Model|string $model): array
    {
        $model = is_string($model) ? new $model : $model;
        $class = get_class($model);

        $relations = [];
        $reflection = new ReflectionClass($model);

        foreach ($reflection->getMethods() as $method) {
            if ($class !== $method->class) {
                continue;
            }

            $code = $this->methodCode($method);

            foreach ($this->relations as $relation) {
                if ($this->returnsRelation($method) || $this->containsRelation($code, $relation)) {
                    $name = $method->getName();
                    $relations[] = $model->{$name}();
                }
            }
        }

        return $relations;
    }

    protected function returnsRelation(ReflectionMethod $method): bool
    {
        $returnType = $method->getReturnType();

        if ($returnType === null) {
            return false;
        }

        switch (get_class($returnType)) {
            case ReflectionNamedType::class:
                return $this->namedReturnIsRelation($returnType);

            case ReflectionUnionType::class:
                return $this->unionReturnIsRelation($returnType);

            case ReflectionIntersectionType::class:
                return $this->intersectionReturnIsRelation($returnType);
        }

        return false;
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
        return in_array($returnType->getName(), $this->relations);
    }

    protected function methodCode(ReflectionMethod $method): string
    {
        $file = new SplFileObject($method->getFileName());
        $code = '';

        $file->seek($method->getStartLine() - 1);

        while ($file->key() < $method->getEndLine()) {
            $code .= $file->current();
            $file->next();
        }

        $code = trim(preg_replace('/\s\s+/', '', $code));
        $begin = strpos($code, '){');
        $end = strrpos($code, '}') - $begin + 1;

        return substr($code, $begin, $end);
    }

    /**
     * @param  class-string<Relation>  $relation
     */
    protected function containsRelation(string $code, string $relation): bool
    {
        $relationMethod = lcfirst(class_basename($relation));

        return stripos($code, '$this->'.$relationMethod.'(') !== false;
    }
}
