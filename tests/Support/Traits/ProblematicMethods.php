<?php

namespace Plank\Larelations\Tests\Support\Traits;

use Exception;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Plank\Larelations\Tests\Support\Contracts\ContractOne;
use Plank\Larelations\Tests\Support\Contracts\ContractTwo;
use Plank\Larelations\Tests\Support\Models\ModelC;

trait ProblematicMethods
{
    public function nonRelationIntersectionReturnType(): ContractOne&ContractTwo
    {
        return new ModelC();
    }

    public function nonRelationUnionReturnType(): ContractOne|HasOne
    {
        return new ModelC();
    }

    public function throwsExceptions()
    {
        throw new Exception('Matches criteria for an Eloquent relation, however exceptions may occur when called without consideration.');
    }

    public function userDefined()
    {
        return 'User defined method that matches criteria for an eloquent relation, but obivously does not return a relation';
    }
}
