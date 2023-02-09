<?php

namespace Plank\Larelations\Tests\Support\Traits;

use Exception;

trait ProblematicMethods
{
    public function throwsExceptions()
    {
        throw new Exception('Matches criteria for an Eloquent relation, however exceptions may occur when called without consideration.');
    }

    public function userDefined()
    {
        return 'User defined method that matches criteria for an eloquent relation, but obivously does not return a relation';
    }
}
