<?php

use Plank\Larelations\RelationInstance;
use Plank\Larelations\Tests\Support\Models\ModelA;
use Plank\Larelations\Tests\Support\Models\ModelB;

it('correctly identifies child relations', function ($name) {
    $model = new ModelA();
    $method = new ReflectionMethod($model, $name);
    $relation = $model->{$name}();
    $instance = new RelationInstance($method, $relation);
    expect($instance->isChild())->toBeTrue();
})->with([
    ['hasOneWithReturnType'],
    ['hasManyWithReturnType'],
    ['hasManyThroughWithReturnType'],
    ['morphOneWithReturnType'],
    ['hasOneThroughWithReturnType'],
    ['morphManyWithReturnType'],
]);

it('correctly identifies parent relations', function ($name) {
    $model = new ModelB();
    $method = new ReflectionMethod($model, $name);
    $relation = $model->{$name}();
    $instance = new RelationInstance($method, $relation);
    expect($instance->isParent())->toBeTrue();
})->with([
    ['belongsToWithReturnType'],
    ['morphToWithReturnType'],
]);

it('correctly identifies pivot relations', function ($name) {
    $model = new ModelA();
    $method = new ReflectionMethod($model, $name);
    $relation = $model->{$name}();
    $instance = new RelationInstance($method, $relation);
    expect($instance->isPivot())->toBeTrue();
})->with([
    ['belongsToManyWithReturnType'],
]);

it('correctly identifies through relations', function ($name) {
    $model = new ModelA();
    $method = new ReflectionMethod($model, $name);
    $relation = $model->{$name}();
    $instance = new RelationInstance($method, $relation);
    expect($instance->isThrough())->toBeTrue();
})->with([
    ['hasManyThroughWithReturnType'],
    ['hasOneThroughWithReturnType'],
]);

it('correctly identifies polymorphic relations', function ($class, $name) {
    $model = new $class();
    $method = new ReflectionMethod($model, $name);
    $relation = $model->{$name}();
    $instance = new RelationInstance($method, $relation);
    expect($instance->isPolymorphic())->toBeTrue();
})->with([
    [ModelA::class, 'morphOneWithReturnType'],
    [ModelA::class, 'morphManyWithReturnType'],
    [ModelB::class, 'morphToWithReturnType'],
]);
