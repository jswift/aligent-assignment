<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */
namespace Finder\ObjectFinder\Location;


/**
 * The source(the solutions found by a specific algorithm) locations
 *
 * @since      Class available since 10 July 2019
 */
class SourceLocations extends MultipleLocationsAbstract
{
    // The definition of its name used in JSON as a key
    const NAME_TAG = "sources";


    /**
     * List all the locations of a multiple-location instance
     *
     * @param $coordinatePrecision
     * @return array<Location>
     */
    public function listLocations($coordinatePrecision = -1)
    {
        $result = array();
        for($i = 0; $i < $this->amount; $i++)
        {
            $result[$i] = $this->locations[$i]->getData($coordinatePrecision);
        }

        return $result;
    }


}