<?php

use Plank\Larelations\Facades\Larelations;
use Plank\Larelations\Tests\Support\Models\ModelA;
use Plank\Larelations\Tests\Support\Models\ModelB;
use Plank\Larelations\Tests\Support\Models\ModelC;

it('extracts relations from a given model', function () {
    expect(Larelations::extract(ModelA::class))->toHaveCount(14);
    expect(Larelations::extract(ModelB::class))->toHaveCount(6);
    expect(Larelations::extract(ModelC::class))->toHaveCount(2);
});
