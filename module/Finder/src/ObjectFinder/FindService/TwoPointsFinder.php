<?php
/**
 * Object Finder (The assignment of coding skills for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\FindService;


use Finder\ObjectFinder\Location\KnownLocations;
use Finder\ObjectFinder\Location\Location;
use Finder\ObjectFinder\Location\SourceLocations;
use Zend\Validator\Sitemap\Loc;

class TwoPointsFinder implements FinderAlgorithmInterface
{
    private $inputs;
    private $results;

    public function __construct()
    {
        $this->results = new SourceLocations();
    }

    public function locate(KnownLocations $locations)
    {
        $this->inputs = $locations;
        $solutions = new Solutions($this->inputs);
        $this->_compute();

        $solutions->setSolutions($this->results);

        return $solutions;

    }

    private function _compute()
    {
        $this->_newMethod();
        return;

        $locations = $this->inputs->getLocations();
        $angle = $this->_getAngleWithXAxis(abs($locations[0]->getX() - $locations[1]->getX()),
                                        abs($locations[0]->getY() - $locations[1]->getY()));

        $rotatedXY = $this->_pointRotate($locations[0], $locations[1], $angle);

        $rotatedSolutions = $this->_getLocationsOnRotated($locations[0],
                                new Location($rotatedXY[0], $rotatedXY[1],
                                            $locations[1]->getDistance()));



        $solutions1 = $this->_pointRotate($locations[0],
                            new Location($rotatedSolutions[0]->getX(),
                                        $rotatedSolutions[0]->getY()),
                             -$angle);

        $solutions2 = $this->_pointRotate($locations[0],
                            new Location($rotatedSolutions[1]->getX(),
                                        $rotatedSolutions[1]->getY()),
                            -$angle);





        var_dump($angle);

        var_dump($rotatedSolutions[0]);
        var_dump($rotatedSolutions[1]);
        var_dump($solutions1);
        if($this->_checkSolution($solutions1))
        {
            $this->results->add(new Location(round($solutions1[0],1),
                                round($solutions1[1],1)));
        }

        var_dump($solutions2);
        if($this->_checkSolution($solutions2))
        {
            $this->results->add(new Location(round($solutions2[0],1),
                                round($solutions2[1], 1)));
        }

    }

    private function _getAngleWithXAxis($x, $y)
    {
        echo "<PRE>";
        /*echo $x."|".$y;
        echo "ANGLE:". (atan(1)*180/pi());*/
        return atan($x/$y)*180/pi();
    }

    private function _pointRotate($location1, $location2, $angle)
    {
        $x1 = ($location2->getX() - $location1->getX()) * cos($angle) + ($location2->getY() - $location1->getY()) * sin($angle) + $location1->getX();
        $y1 = -($location2->getX() - $location1->getX()) * sin($angle) + ($location2->getY() - $location1->getY()) * cos($angle) + $location1->getY();
        return array(round($x1,100), round($y1,100));
    }

    private function _getLocationsOnRotated(Location $location1, Location $location2)
    {
        $leftLocation = $location2;
        $rightLocation = $location1;

        if($location1->getX() < $location2->getX())
        {
            $leftLocation = $location1;
            $rightLocation = $location2;
        }

        $distance = abs($rightLocation->getX() - $leftLocation->getX());

        //var_dump($leftLocation->getDistance());

        $xOffset = ($distance**2 - $rightLocation->getDistance()**2 + $leftLocation->getDistance()**2)/($distance*2);
        $yOffset = sqrt($leftLocation->getDistance()**2 - $xOffset**2);


        //echo "<PRE>";
        $solution1 = new Location($leftLocation->getX()+$xOffset, $leftLocation->getY()+$yOffset);
        $solution2 = new Location($leftLocation->getX()+$xOffset, $leftLocation->getY()-$yOffset);


        return array($solution1, $solution2);
    }

    private function _checkSolution($solution)
    {
        $inputs = $this->inputs->getLocations();

        //var_dump($solution);

        foreach ($inputs as $input)
        {

            //var_dump($input);
            $a = $input->getX()-$solution[0];
            $b = $input->getY()-$solution[1];
            $c = $input->getDistance();
            var_dump((($a**2+$b**2-$c**2) < 0.0001));


            echo ($a**2)."|". ($b**2)."|".($c**2)."\n";
            if(($a**2+$b**2-$c**2) > 0.0001)
            {
                return false;
            }

            echo "=================\n";
        }
        return true;
    }

    private function _newMethod()
    {
        echo "<pre>";
        echo "sin(45):".sin(45*pi()/180)."\n";
        echo "sin(-45):".sin(-45*pi()/180)."\n";
        echo "sin(315):".sin(315*pi()/180)."\n";
        echo "sin(pi())".sin(-1.578)."\n";

        $input1 = $this->inputs->getLocations()[0];
        $input2 = $this->inputs->getLocations()[1];

        $small = $input1;
        $big = $input2;
        if($input1->getDistance() > $input2->getDistance())
        {
            $small = $input2;
            $big = $input1;
        }
        elseif($input1->getDistance() == $input2->getDistance())
        {
            if ($input1->getX() < $input2->getX())
            {
                $small = $input2;
                $big = $input1;
            }
            elseif($input1->getX() == $input2->getX())
            {
                if($input1->getY() < $input2->getY())
                {
                    $small = $input2;
                    $big = $input1;
                }
            }

        }

        $R = $big->getDistance();
        $r = $small->getDistance();

        $D = sqrt(($input1->getX() - $input2->getX())**2 + ($input1->getY() - $input2->getY())**2);
        var_dump($D);

        $cosAlpha = ($R**2 + $D**2 - $r**2)/(2*$D*$R);
        var_dump($cosAlpha);

        $alpha = acos($cosAlpha)*180/pi();
        echo "A:";
        var_dump($alpha);

        $y = ($small->getY() - $big->getY());

        $x = ($small->getX() - $big->getX());

        if($x == 0)
        {
            $beta = 90;
        }
        else
        {
        $beta = atan(abs($y/$x))*180/pi();
        }


        echo "BETA0:";
        var_dump($beta);

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

        echo "BETA1:";
        var_dump($beta);

        // TODO: handle if y ==0 and x==0 and return no solution

        $xxxx = cos(($beta*pi()/180)+$alpha*pi()/180);
        $x1 = $big->getX()+($R*$xxxx);
        $y1 = $big->getY()+$R*sin(($beta*pi()/180)+$alpha*pi()/180);


        echo "R=$R,"."cos((\$beta*pi()/180)+\$alpha*pi()/180)=".$big->getX();

        $x2 = $big->getX()+$R*cos(($beta*pi()/180)-$alpha*pi()/180);
        $y2 = $big->getY()+$R*sin(($beta*pi()/180)-$alpha*pi()/180);

        echo "<PRE>\n======\n";
        var_dump(array($x1, $y1, $x2, $y2));
        echo "\n======\n";


        if($this->_checkSolution(array($x1, $y1))) {
            $this->results->add(new Location(round($x1, 1),
                round($y1, 1)));
        }

        if($this->_checkSolution(array($x2, $y2))) {
            $this->results->add(new Location(round($x2, 1),
                round($y2, 1)));
        }
    }


    public static function checkKnownData(KnownLocations $locations)
    {
        // TODO: Implement checkKnowData() method.
    }
}