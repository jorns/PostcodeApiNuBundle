<?php

namespace FH\Bundle\PostcodeApiNuBundle\Model;

class PostalCodeGeo
{
    public $postalCode;
    public $latitude;
    public $longitude;

    public function __construct($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function __toString()
    {
        return (string)$this->postalCode;
    }
}
