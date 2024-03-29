<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\Location;

/**
 * The known(the inputs given by the client) locations
 *
 * @since      Class available since 10 July 2019
 */
class KnownLocations extends MultipleLocationsAbstract
{
    const NAME_TAG = "samples";

    /**
     * List all the locations in the current instance
     *
     * @param $coordinatePrecision
     * @return array<Location>
     */
    public function listLocations($coordinatePrecision = Location::NO_COORDINATE_PRECISION)
    {
        $result = array();
        for($i = 0; $i < $this->amount; $i++)
        {
            $result[$i] = $this->locations[$i]->getData($coordinatePrecision, $includingDistance = true);
        }

        return $result;
    }
}