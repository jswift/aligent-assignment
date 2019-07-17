<?php
/**
 * Object Finder (The assignment of coding skills for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\FindService;

/**
 * The definition of a finder's algoritm
 *
 * @since      Class available since 11 July 2019
 */
use Finder\ObjectFinder\Location\KnownLocations;

interface FinderAlgorithmInterface
{

    /**
     * Start the computing of an algoritm
     *
     * @param $locations
     * @return Solutions
     */
    public function locate(KnownLocations $locations);


    /**
     * The validator
     *
     * @param $locations
     * @return true/false
     */
    public static function checkKnownData(KnownLocations $locations);
}