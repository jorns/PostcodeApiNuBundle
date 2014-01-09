<?php

namespace FH\Bundle\PostcodeApiNuBundle\Form\DataTransformer;

use FH\Bundle\PostcodeApiNuBundle\Model\PostalCodeGeo;
use PostcodeApiNu\ServiceInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PostalCodeGeoTransformer implements DataTransformerInterface
{
    /**
     * @var \PostcodeApiNu\ServiceInterface
     */
    private $postalCodeService;

    /**
     * @param ServiceInterface $postalCodeService
     */
    public function __construct(ServiceInterface $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService;
    }

    /**
     * @param mixed $postalCodeGeo
     * @return mixed
     */
    public function transform($postalCodeGeo)
    {
        return $postalCodeGeo instanceof PostalCodeGeo ? $postalCodeGeo->postalCode : $postalCodeGeo;
    }

    /**
     * @param mixed $postalCode
     * @return PostalCodeGeo
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform($postalCode)
    {
        $postalCode = new PostalCodeGeo($postalCode);
        try{
            $location = $this->postalCodeService->find($postalCode->postalCode);
            $postalCode->latitude = $location->latitude;
            $postalCode->longitude = $location->longitude;
        } catch (\exception $e) {
            //No further action
        }

        return $postalCode;
    }
}
