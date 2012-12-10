<?php
namespace FH\Bundle\PostcodeApiNuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Address extends Constraint
{
    public $message = 'This provided address with postal code "%postalCode%" and number "%number%" appears to be invalid.';

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'postcode_api_nu_address_validator';
    }
}