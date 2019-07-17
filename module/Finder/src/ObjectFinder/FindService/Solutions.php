<?php
/**
 * Object Finder (The assignment of coding skills for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\ObjectFinder\FindService;


use Finder\ObjectFinder\Location\KnownLocations;
use Finder\ObjectFinder\Location\SourceLocations;
use Zend\Json\Json;

/**
 * The definition of solutions(0 or more)
 *
 * @since      Class available since 12 July 2019
 */
class Solutions
{
    private $inputs;
    private $solutions;

    private $algorithm;

    private $startTime = -1;
    private $endTime = -1;
    private $timeConsuming = 0;

    /**
     * The constructor
     *
     * @param $inputs
     */
    public function __construct(KnownLocations $inputs)
    {
        $this->setInputs($inputs);
        $this->start();
    }

    /**
     * @return mixed
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * @param mixed $inputs
     */
    public function setInputs(KnownLocations $inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * @return mixed
     */
    public function getSolutions()
    {
        return $this->solutions;
    }

    /**
     * @param mixed $solutions
     */
    public function setSolutions(SourceLocations $solutions)
    {
        $this->solutions = $solutions;
        $this->end();
    }

    public function getSolutionSize()
    {
        return count($this->getSolutions());
    }

    /**
     * @return mixed
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param mixed $algorithm
     */
    public function setAlgorithm(FinderAlgorithmInterface $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @return int
     */
    public function getTimeConsuming()
    {
        return $this->timeConsuming;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param int $startTime
     */
    public function start()
    {
        $this->startTime = microtime(true);
    }

    /**
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param int $endTime
     */
    public function end()
    {
        $this->endTime = microtime(true);
        $this->timeConsuming = $this->endTime - $this->startTime;
    }

    /**
     * Get all the results
     *
     * @return  array<Inputs, Solutions>
     */
    public function getResult()
    {
        $inputs = $this->getInputs()->listLocations();
        $outpus = $this->getSolutions()->listLocations();
        return array(KnownLocations::NAME_TAG => $inputs,
                        SourceLocations::NAME_TAG => $outpus);
    }
}