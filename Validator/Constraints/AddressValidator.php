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
        $number = call_user_func(array($value, $constraint->numberGetter));
        $postalCode = call_user_func(array($value, $constraint->postalCodeGetter));
        if (null !== $postalCode && null !== $number)
        {
            try
            {
                $data = $this->postalCodeService->find($postalCode, $number);

                if (isset($constraint->streetSetter, $data->street))
                {
                    call_user_func(array($value, $constraint->streetSetter), $data->street);
                }
                if (isset($constraint->citySetter, $data->town))
                {
                    call_user_func(array($value, $constraint->citySetter), $data->town);
                }
            } catch (\RuntimeException $e) {
                $this->context->addViolation($constraint->message, array('%postalCode%' => $postalCode, '%number%' => $number));
            }
        } else {
            $this->context->addViolation($constraint->message, array('%postalCode%' => $postalCode, '%number%' => $number));
        }
    }
}