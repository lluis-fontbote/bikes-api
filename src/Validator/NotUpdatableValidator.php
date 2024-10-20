<?php

namespace App\Validator;

use App\Repository\BikeRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotUpdatableValidator extends ConstraintValidator
{
    protected BikeRepository $bikeRepository;

    public function __construct(BikeRepository $bikeRepository)
    {
        $this->bikeRepository = $bikeRepository;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof NotUpdatable) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}