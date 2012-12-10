<?php
namespace FH\Bundle\PostcodeApiNuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use PostcodeApiNu\Service;

class AddressValidator extends ConstraintValidator
{
    protected $postalCodeService;

    public function __construct(Service $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService;
    }

    public function validate($value, Constraint $constraint)
    {
        var_dump($value);
        echo __METHOD__;die;
        if (!preg_match('/^[a-zA-Za0-9]+$/', $value, $matches)) {
            $this->context->addViolation($constraint->message, array('%string%' => $value));
        }
    }
}