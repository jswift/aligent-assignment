<?php
/**
 * Object Finder (The assignment of coding skills for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\Location;

/**
 * The abstract definition of a multiple-location
 *
 * @since      Class available since 10 July 2019
 */
abstract class MultipleLocationsAbstract
{
    public $amount = 0;
    public $locations = array();

    /**
     * A definition of listing locations for sub-classes
     *
     * @param $coordinatePrecision
     * @return Locations
     */
    abstract public function listLocations($coordinatePrecision = -1);

    /**
     * Add one location as a result
     *
     * @param $location
     */
    public function add(Location $location)
    {
        $this->locations[] = $location;
        $this->amount++;
    }

    /**
     * Remove one of the locations
     */
    public function remove(int $index)
    {
        $this->locations[$index] = null;
        $this->amount--;
    }

    /**
     * Get the amount of locations
     *
     * @return int
     */
    public function size()
    {
        return $this->amount;
    }

    /**
     * @return locations
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Clear all the data of current instance
     */
    public function clear()
    {
        $this->locations = null;
        $this->locations = array();
        $this->amount = 0;
    }


}