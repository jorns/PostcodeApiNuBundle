<?php
namespace FH\Bundle\PostcodeApiNuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use PostcodeApiNu\ServiceInterface;

class PostalCodeValidator extends ConstraintValidator
{
    protected $postalCodeService;

    public function __construct(ServiceInterface $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService;
    }

    public function validate($postalCode, Constraint $constraint)
    {
        /** @var PostalCode $constraint */
        if ('' !== (string)$postalCode) {
            try {
                $data = $this->postalCodeService->find($postalCode);
            } catch (\RuntimeException $e) {
                $this->context->addViolation($constraint->message, array('%postalCode%' => $postalCode));
            }
        }
    }
}
