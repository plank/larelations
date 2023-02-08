<?php

namespace Plank\Larelations\Facades;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Plank\Larelations\RelationExtractor
 *
 * @method static void addRelation(class-string<Relation> $relation)
 * @method static void addRelations(array<class-string<Relation>> $relations)
 * @method static array<Relation> extract(Model|class-string<Model> $model)
 */
class Larelations extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Plank\Larelations\RelationExtractor::class;
    }
}
