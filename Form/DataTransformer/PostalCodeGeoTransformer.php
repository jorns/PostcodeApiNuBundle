<?php

namespace FH\Bundle\PostcodeApiNuBundle\Form\DataTransformer;

use FH\Bundle\PostcodeApiNuBundle\Model\PostalCodeGeo;
use PostcodeApiNu\Service as PostcodeApiNuService;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PostalCodeGeoTransformer implements DataTransformerInterface
{
    /**
     * @var \FH\Bundle\PostcodeApiNuBundle\Model\PostalCodeGeo
     */
    private $postalCodeService;

    /**
     * @param PostcodeApiNuService $postalCodeService
     */
    public function __construct(PostcodeApiNuService $postalCodeService)
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
            throw new TransformationFailedException('Postalcode transformation failed');
        }

        return $postalCode;
    }
}
