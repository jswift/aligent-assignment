<?php

namespace Finder\Controller;


use http\Client;

class ObjectsControllerTest extends \PHPUnit_Framework_TestCase
{
    private $httpClient;
    const HOST = "http://zf.local.net";
    const DEFAULT_URL = "v1.0/object-finder/objects";
    public function setUp()
    {
        parent::setUp();
        $this->httpClient = new \GuzzleHttp\Client(array("base_uri"=>self::HOST));

    }

    public function testPostActionCaseA()
    {
        $correctResult = array("samples"=>array(
                                array('x'=>1.0,'y'=>1.0,'distance'=>5.0),
                                array('x'=>3.0,'y'=>3.0,'distance'=>5.0)),
                            "sources"=>array(
                                array('x'=>-1.4,'y'=>5.4),
                                array('x'=>5.4,'y'=>-1.4))
                            );

        $inputs = '{"samples": [{"x": 1.0,"y": 1.0,"distance": 5.0}, {"x": 3.0,"y": 3.0,"distance": 5.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }

    public function testPostActionCaseB()
    {
        $correctResult = array("samples"=>array(
            array('x'=>6.0,'y'=>8.0,'distance'=>5.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>10.0)),
            "sources"=>array(
                array('x'=>1.4,'y'=>9.9),
                array('x'=>9.1,'y'=>4.1))
        );

        $inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 10.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }


    public function testPostActionCaseC()
    {
        $correctResult = array("samples"=>array(
            array('x'=>6.0,'y'=>8.0,'distance'=>5.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>15.0)),
            "sources"=>array(
                array('x'=>9.0,'y'=>12.0))
        );

        $inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 15.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }

    public function testPostActionCaseD()
    {
        $correctResult = array("samples"=>array(
            array('x'=>6.0,'y'=>8.0,'distance'=>5.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>12.0)),
            "sources"=>array(
                array('x'=>2.6,'y'=>11.7),
                array('x'=>10.5,'y'=>5.8))
        );

        $inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 12.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }

    public function testPostActionCaseE()
    {
        $correctResult = array("samples"=>array(
            array('x'=>6.0,'y'=>8.0,'distance'=>12.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>5.0)),
            "sources"=>array(
                array('x'=>3.4,'y'=>-3.7),
                array('x'=>-4.5,'y'=>2.2))
        );

        $inputs = '{"samples": [{"x": 6.0,"y": 8.0,"distance": 12.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }


    public function testPostActionCaseF()
    {
        $correctResult = array("samples"=>array(
            array('x'=>-6.0,'y'=>-8.0,'distance'=>5.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>5.0)),
            "sources"=>array(
                array('x'=>-3.0,'y'=>-4.0))
        );

        $inputs = '{"samples": [{"x": -6.0,"y": -8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }

    public function testPostActionCaseG()
    {
        $correctResult = array("samples"=>array(
            array('x'=>-6.0,'y'=>-8.0,'distance'=>5.0),
            array('x'=>0.0,'y'=>0.0,'distance'=>5.0)),
            "sources"=>array(
                array('x'=>-3.0,'y'=>-4.0))
        );

        $inputs = '{"samples": [{"x": -6.0,"y": -8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';
        $this->assertEquals($correctResult, $this->_jsonRequest($inputs));
    }

    private function _jsonRequest($data, $method="post", $url = self::DEFAULT_URL)
    {
        $response = $this->httpClient->request($method, $url,array("body"=>$data));
        return json_decode($response->getBody(), true);
    }

    public function testPostAction_Get()
    {
        $inputs = '{"samples": [{"x": -6.0,"y": -8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}';

        $response = null;
        try {
            $response = $this->httpClient->request("get", self::DEFAULT_URL, array("body" => $inputs));
        } catch (\GuzzleHttp\Exception\ServerException $se) {
            //var_dump($se);
        }

        $this->assertNull($response);
    }
}
