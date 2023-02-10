<?php

namespace Plank\Larelations\Facades;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Plank\Larelations\RelationInstance;

/**
 * @see \Plank\Larelations\Extractor
 *
 * @method static void addRelation(class-string<Relation> $relation)
 * @method static void addRelations(array<class-string<Relation>> $relations)
 * @method static Collection<RelationInstance> extract(Model|class-string<Model> $model)
 */
class Larelations extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Plank\Larelations\Extractor::class;
    }
}
