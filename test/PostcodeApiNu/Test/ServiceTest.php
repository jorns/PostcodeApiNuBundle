<?php

namespace PostcodeApiNu\Test;

use PostcodeApiNu\Client;
use PostcodeApiNu\Service;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceResponse()
    {
        $someDummyKey = 'asdf';
        $postalCodeService = new Service(new Client($someDummyKey));

        // It must either succeed with all data present or fail with a logic exception.
        try {
            $response = $postalCodeService->find('5041EB', 21);
            $data = $response->getData();
            $this->assertNotNull($data->street);
            $this->assertNotNull($data->postcode);
            $this->assertNotNull($data->town);
            $this->assertNotNull($data->latitude);
            $this->assertNotNull($data->longitude);
        } catch (\exception $e) {
            $this->assertTrue($e instanceof \RuntimeException);
        }
    }
}
