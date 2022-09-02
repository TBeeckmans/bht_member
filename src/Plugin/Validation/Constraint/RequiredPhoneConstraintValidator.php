<?php

namespace Drupal\bht_member\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RequiredPhoneConstraintValidator extends ConstraintValidator {

  /**
   * @inheritDoc
   */
  public function validate($entity, Constraint $constraint) {
    $phone = $entity->field_phone->value;
    $mobile_phone = $entity->field_mobile_phone->value;

    if (empty($phone) && empty($mobile_phone)) {
      $this->context->buildViolation($constraint->messageRequired)
        ->atPath('phone')
        ->addViolation();
      $this->context->buildViolation($constraint->messageRequired)
        ->atPath('mobile_phone')
        ->addViolation();
    }
  }
}
