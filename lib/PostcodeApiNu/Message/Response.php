<?php

namespace PostcodeApiNu\Message;
use Buzz\Message\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * @return array
     * @throws \RuntimeException
     */
    public function getData()
    {
        //@TODO Create a more dynamic setup so it is able to support other content-type's
        if ($this->getHeader('Content-Type') === 'application/json')
        {
            return json_decode($this->getContent());
        }

        throw new \RuntimeException('The Content-Type could not be decoded');
    }
}
