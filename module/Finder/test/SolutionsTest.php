<?php

namespace Finder\ObjectFinder\FindService;

use Finder\ObjectFinder\Location\KnownLocations;
use Finder\ObjectFinder\Location\Location;
use PHPUnit\Framework\TestCase;

class SolutionsTest extends TestCase
{

    public function testGetInputs()
    {
        $inputs = array("samples"=>array(array("x"=>6.0, "y"=>8.0, "distance"=>5.0), array("x"=>0.0, "y"=>0.0, "distance"=>5.0)));
        $knownLocations = new KnownLocations();
        foreach ($inputs[KnownLocations::NAME_TAG] as $key => $value)
        {
            $location = new Location($value[Location::NAME_X],
                $value[Location::NAME_Y],
                $value[Location::NAME_DISTANCE]);

            $knownLocations->add($location);
        }
        $solution = new Solutions($knownLocations);
        $this->assertEquals($knownLocations, $solution->getInputs());
    }
}
