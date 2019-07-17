<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\FindService;


use Finder\ObjectFinder\Location\KnownLocations;
use Finder\ObjectFinder\Location\Location;
use Finder\ObjectFinder\Location\SourceLocations;
use Zend\Validator\Sitemap\Loc;

/**
 * Finding algorithm by two given data points
 **
 * @since      Class available since 10 July 2019
 */
class TwoPointsFinder implements FinderAlgorithmInterface
{
    private $inputs;
    private $results;

    // A tolerance value for checking the solution
    const TOLERANCE = 0.0001;

    const REQUIRED_KNOWN_LOCATIONS_SIZE = 2;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->results = new SourceLocations();
    }

    /**
     * To locate the object
     *
     * @param KnownLocations $locations
     * @return Solutions
     */
    public function locate(KnownLocations $locations)
    {
        $this->inputs = $locations;
        $solutions = new Solutions($this->inputs);
        $this->_compute();

        $solutions->setSolutions($this->results);

        return $solutions;
    }

    /**
     * The validator
     *
     * @param $locations
     * @return true/false
     */
    public static function checkKnownData(KnownLocations $locations)
    {
        if ($locations == null)
        {
            return false;
        }
        elseif($locations->size() != self::REQUIRED_KNOWN_LOCATIONS_SIZE)
        {
            return false;
        }

        $data = $locations->getLocations();
        foreach ($data as $single)
        {
            if($single->getDistance() <= 0)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Compute at most two possible locations by calculating three angles.
     *   save the solution into $this->results.
     */
    private function _compute()
    {
        // Find which is the bigger one or the smaller one
        $comparedLocations = $this->_compareLocations();

        $smallCircle = $comparedLocations[0];
        $bigCircle   = $comparedLocations[1];

        // Calculate the distances for each circle
        $x = $smallCircle->getX() - $bigCircle->getX();
        $y = $smallCircle->getY() - $bigCircle->getY();

        // Get the radius for each circle
        $smallRadius = $smallCircle->getDistance();
        $bigRadius   = $bigCircle->getDistance();

        // Calculate the length of the connected line between two centre
        //     points of two circles
        $distance    = sqrt($x**2 + $y**2);

        // Cauculate the angles
        $alpha = $this->_calculateAlpha($bigRadius, $smallRadius, $distance);
        $beta  = $this->_calculateBeta($x, $y);

        // Cauclate the two cross points
        $x1 = $bigCircle->getX() + $bigRadius * cos($beta + $alpha);
        $y1 = $bigCircle->getY() + $bigRadius * sin($beta + $alpha);
        $x2 = $bigCircle->getX() + $bigRadius * cos($beta - $alpha);
        $y2 = $bigCircle->getY() + $bigRadius * sin($beta - $alpha);

        // Check the first solution
        if($this->_checkSolution(array($x1, $y1)))
        {
            $this->results->add(new Location($x1, $y1));
        }

        // Check the second solution. If the alpha value is zero,
        //     that means there is only one solution
        if($alpha != 0 && $this->_checkSolution(array($x2, $y2)))
        {
            $this->results->add(new Location($x2, $y2));
        }
    }

    /**
     * Check the solution:
     *  to make sure all solutions are one the edge of the two circles
     *
     * @param $solution
     * @return boolean
     */
    private function _checkSolution($solution)
    {
        $inputs = $this->inputs->getLocations();

        foreach ($inputs as $input)
        {
            $lengthA = $input->getX()-$solution[0];
            $lengthB = $input->getY()-$solution[1];
            $lengthC = $input->getDistance();

            if(($lengthA**2 + $lengthB**2 - $lengthC**2) > self::TOLERANCE)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Compare two locations and find out which is the smaller, which is bigger
     *
     * @return array<Location>
     */
    private function _compareLocations()
    {
        $input1 = $this->inputs->getLocations()[0];
        $input2 = $this->inputs->getLocations()[1];

        $smallCircle = $input1;
        $bigCircle   = $input2;
        if($input1->getDistance() > $input2->getDistance())
        {
            $smallCircle = $input2;
            $bigCircle   = $input1;
        }
        elseif($input1->getDistance() == $input2->getDistance())
        {
            if ($input1->getX() < $input2->getX())
            {
                $smallCircle = $input2;
                $bigCircle   = $input1;
            }
            elseif($input1->getX() == $input2->getX())
            {
                if($input1->getY() < $input2->getY())
                {
                    $smallCircle = $input2;
                    $bigCircle   = $input1;
                }
            }
        }

        return array($smallCircle, $bigCircle);
    }

    /**
     * Calculate the beta value by given $x and $y.
     *
     * @param $x
     * @param $y
     * @return float
     */
    private function _calculateBeta($x, $y)
    {
        if($x == 0)
        {
            $beta = 90;
        }
        else
        {
            $beta = atan(abs($y/$x))*180/pi();
        }

        if($y > 0 && $x <0)
        {
            $beta = 180-$beta;
        }
        elseif($y <=0 && $x <0)
        {
            $beta = 180+$beta;
        }
        elseif($y < 0 && $x >0)
        {
            $beta = 360-$beta;
        }

        return $this->_angleToRadian($beta);
    }

    /**
     * Calculate the alpha value by given radius of each circle.
     *
     * @param $x
     * @param $y
     * @return float
     */
    private function _calculateAlpha($bigRadius, $smallRadius, $distance)
    {
        $cosAlpha = ($bigRadius**2 + $distance**2 -
                $smallRadius**2)/(2*$distance*$bigRadius);

        return acos($cosAlpha);
    }

    /**
     * Tool: convert radian value to angle value
     *
     * @param $radian
     * @return float
     */
    private function _radianToAngle($radian)
    {
        return $radian*180/pi();
    }

    /**
     * Tool: convert angle value to radian value
     *
     * @param $angle
     * @return float
     */
    private function _angleToRadian($angle)
    {
        return $angle*pi()/180;
    }

}