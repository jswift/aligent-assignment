<?php
/**
 * Object Finder (The assignment of coding skills for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\Location;

/**
 * A location
 *
 * @since      Class available since 10 July 2019
 */
class Location
{
    private $x;
    private $y;
    private $distance;

    // Definitions of the keys
    const NAME_X = "x";
    const NAME_Y = "y";
    const NAME_DISTANCE = "distance";

    /**
     * The constructor
     *
     * @param $x
     * @param $y
     * @param $distance
     */
    public function __construct($x, $y, $distance = -1)
    {
        $this->x = $x;
        $this->y = $y;
        $this->distance = $distance;
    }

    /**
     * Get the locations' data
     *
     * @param $includingDistance
     * @return array
     */
    public function getData($includingDistance = false)
    {
        $result = array(self::NAME_X=> $this->x, self::NAME_Y => $this->y);

        if($includingDistance){
            $result[self::NAME_DISTANCE] = $this->distance;
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }


}