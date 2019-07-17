<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder\Controller;

use Finder\ObjectFinder\FindService\FindService;
use Finder\ObjectFinder\FindService\TwoPointsFinder;
use Finder\ObjectFinder\Location\KnownLocations;
use Finder\ObjectFinder\Location\Location;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;

/**
 * The main controller of the objects finding services
 *
 * This service mainly uses JSON as the response format of each functions.
 *
 * @since      Class available since 10 July 2019
 */
class ObjectsController extends AbstractActionController
{

    /**
     * Init the controller to switch to JSON mode.
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('search', array('json'))
            ->initContext();
    }

    /**
     * Handle all the requests from HTTP clients and distribute to other functions
     *
     * @return JSON string
     */
    public function indexAction()
    {
        $method = strtoupper($this->params()->fromQuery("method", Request::METHOD_GET));
        switch ($method)
        {
            case Request::METHOD_GET:
                //return $this->_getAction();
                return $this->_postAction();
                break;
            case Request::METHOD_POST:
                return $this->_postAction();
                break;
            case Request::METHOD_DELETE:
                return $this->_delAction();
                break;
            case Request::METHOD_PUT:
                return $this->_putAction();
                break;
            default:
                return $this->_unknownAction();
        }
    }

    /**
     * Handle the POST actions which processes the behaviours to search objects
     *
     * @return JSON View
     */
    private function _postAction()
    {
        $inputs = '{"samples": [{"x": 1.0,"y": 1.0,"distance": 5.0}, {"x": 3.0,"y": 3.0,"distance": 5.0}]}';

        $inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 10.0}]}';

        //$inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 15.0}]}';

        //$inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 12.0}]}';

        //$inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 12.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';

        //$inputs = '{"samples": [{"x": -6.0,"y": -8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';

        try {
            $inputsValues = Json::decode($inputs, Json::TYPE_ARRAY);
        }
        catch (\JsonException $eJson)
        {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            return $this->_getErrorResponse("Invalid inputs:" . $eJson->getMessage());
        }

        if(!$this->_checkInputs($inputsValues))
        {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_401);
            return $this->_getErrorResponse("Invalid inputs");
        }

        $knownLocations = new KnownLocations();

        foreach ($inputsValues[KnownLocations::NAME_TAG] as $key => $value)
        {
            $location = new Location($value[Location::NAME_X],
                                        $value[Location::NAME_Y],
                                            $value[Location::NAME_DISTANCE]);

            $knownLocations->add($location);
        }

        // TODO: move to config file
        $algorithm = TwoPointsFinder::class;
        $solver = new FindService(new $algorithm);
        $solutions = $solver->find($knownLocations);

        return new JsonModel($solutions->getResult());
    }


    /**
     * Generate error data with given messages
     *
     * @param $message the error message
     * @return JSON View
     */
    private function _getErrorResponse($message)
    {
        $data = array("Error" => $message);

        return new JsonModel($data);
    }

    /**
     * Check the validity of the inputs with basic rules
     *
     * @param $inputsValues the inputs values in an array
     * @return boolean true for valid inputs and false for invalid inputs
     */
    private function _checkInputs($inputsValues)
    {
        if (!is_array($inputsValues) ||
            !isset($inputsValues[KnownLocations::NAME_TAG]) ||
                count($inputsValues[KnownLocations::NAME_TAG]) == 0)
        {
            return false;
        }
        return true;
    }

    /**
     * Handle the GET actions and notify the client with an error code 501
     * in HTTP Header to dedicate unimplemented
     *
     * @return void
     */
    private function _getAction()
    {
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_501);
    }

    /**
     * Handle the DELETE actions and notify the client with an error code 501
     * in HTTP Header to dedicate unimplemented
     *
     * @return void
     */
    private function _delAction()
    {
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_501);
    }

    /**
     * Handle the PUT actions and notify the client with an error code 501
     * in HTTP Header to dedicate unimplemented
     *
     * @return void
     */
    private function _putAction()
    {
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_501);
    }

    /**
     * Handle all other actions and notify the client with an error code 405
     * in HTTP Header to dedicate unknown operations
     *
     * @return void
     */
    private function _unknownAction()
    {
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_405);
    }
}