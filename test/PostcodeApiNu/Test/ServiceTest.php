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
            $this->assertTrue($data->success);
            $this->assertTrue($data->resource instanceof \stdClass);
            $this->assertNotNull($data->resource->street);
            $this->assertNotNull($data->resource->postcode);
            $this->assertNotNull($data->resource->town);
            $this->assertNotNull($data->resource->latitude);
            $this->assertNotNull($data->resource->longitude);
        } catch (\exception $e) {
            $this->assertTrue($e instanceof \RuntimeException);
        }
    }
}
