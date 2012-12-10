<?php
namespace PostcodeApiNu;

use Buzz\Message\Request;
use Buzz\Client\FileGetContents;
use Buzz\Client\ClientInterface;


class Service
{
    /**
     * @var \PostcodeApiNu\Client
     */
    protected $apiClient;

    /**
     * @var \Buzz\Client\ClientInterface
     */
    protected $client;

    public function __construct(Client $apiClient, ClientInterface $client = null)
    {
        $this->apiClient = $apiClient;
        $this->client = $client ? : new FileGetContents;
    }

    /**
     * @param $postalCode
     * @param null $number
     * @return array
     * @throws \RuntimeException
     */

    public function find($postalCode, $number = null)
    {
        $request = clone $this->apiClient->getHttpRequest();
        $params = array($postalCode);
        if (null !== $number)
        {
            $params[] = $number;
        }
        $request->setResource('/' . implode('/', $params));
        $response = new Message\Response();
        $this->client->send($request, $response);


        if ($response->getStatusCode() != 200)
        {
            throw new \RuntimeException(sprintf('Request failed with response code: %s', $response->getStatusCode()));
        }

        return $response->getData()->resource;
    }
}