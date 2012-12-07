<?php

namespace PostcodeApiNu\Test;

use PostcodeApiNu\Client;
use PostcodeApiNu\Service;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testPostalCodeAndNumberMethods()
    {
        $someDummyKey = 'asdf';
        $client = new Client($someDummyKey);
        new Service($client);

        $this->assertEquals($client->getHttpRequest()->getHeader('Api-Key'), $someDummyKey);
    }
}
