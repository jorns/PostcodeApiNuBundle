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
        /** @var $constraint Address */

        $number = call_user_func(array($value, $constraint->numberGetter));
        $postalCode = call_user_func(array($value, $constraint->postalCodeGetter));

        if (null !== $postalCode && null !== $number) {
            try {
                $postalCode = preg_replace('/\s+/', '', $postalCode);
                $data = $this->postalCodeService->find($postalCode, trim($number));

                if (isset($constraint->streetSetter, $data->street)) {
                    call_user_func(array($value, $constraint->streetSetter), $data->street);
                }
                if (isset($constraint->citySetter, $data->town)) {
                    call_user_func(array($value, $constraint->citySetter), $data->town);
                }
            } catch (\RuntimeException $e) {
                $this->addViolationMessage($constraint, $postalCode, $number);
            }
        } else {
            $this->addViolationMessage($constraint, $postalCode, $number);
        }
    }

    protected function addViolationMessage(Constraint $constraint, $postalCode, $number)
    {
        /** @var $constraint Address */

        if ($constraint->errorProperty) {
            $this->context->addViolationAtPath(
                $this->context->getPropertyPath() . '.' . $constraint->errorProperty,
                $constraint->message,
                array('%postalCode%' => $postalCode, '%number%' => $number)
            );
        } else {
            $this->context->addViolation(
                $constraint->message,
                array('%postalCode%' => $postalCode, '%number%' => $number)
            );
        }
    }
}
