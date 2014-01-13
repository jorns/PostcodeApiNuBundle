<?php
namespace FH\Bundle\PostcodeApiNuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PostalCode extends Constraint
{
    public $message = 'This provided postal code "%postalCode%" appears to be invalid.';

    public $validatorService = 'postcode_api_nu_postal_code_validator';

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy()
    {
        return $this->validatorService;
    }
}
