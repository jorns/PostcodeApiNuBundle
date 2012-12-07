<?php
namespace PostcodeApiNu;

use Buzz\Message\Request;

class Client
{
    protected $apiKey;

    protected $apiHost = 'http://staging.postcode.freshheads.com';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getHttpRequest()
    {
        $request = new Request('GET', '/', $this->apiHost);
        $request->addHeader('Api-Key: ' . $this->apiKey);

        return $request;
    }
}