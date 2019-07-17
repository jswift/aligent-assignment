<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\FindService;


use Finder\ObjectFinder\Location\KnownLocations;

/**
 * The entrance of the object finding service
 *
 * @since      Class available since 14 July 2019
 */
class FindService
{

    private $algorithm;

    /**
     * The constructor
     */
    public function __construct(FinderAlgorithmInterface $finderAlgorithm)
    {
        $this->algorithm = $finderAlgorithm;
    }

    /**
     * Set an algoritm for the current instance
     *
     * @param FinderAlgorithmInterface $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get the current algorithm
     *
     * @return FinderAlgorithmInterface
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * The interface to call the algoritm's method
     *
     * @param $locations
     * @return a Solution object
     */
    public function find(KnownLocations $locations)
    {

        if ($this->algorithm->checkKnownData($locations))
        {
            $solution = $this->algorithm->locate($locations);
            $solution->setAlgorithm($this->algorithm);

        }
        else
        {
            $solution = new Solutions($locations);
        }

        return $solution;
    }
}