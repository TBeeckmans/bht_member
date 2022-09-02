<?php

namespace Drupal\bht_member\Plugin\Validation\Constraint;

use Drupal\Core\Entity\Plugin\Validation\Constraint\CompositeConstraintBase;

/**
 * Checks that the submitted user entity contains one required phone number.
 *
 * @Constraint(
 *   id = "RequiredPhoneConstraint",
 *   label = @Translation("Required phone", context = "Validation"),
 *   type = "entity:user"
 * )
 */
class RequiredPhoneConstraint extends CompositeConstraintBase {

  /**
   * Message shown when there is no phone number provided for the user.
   *
   * @var string
   */
  public $messageRequired = 'You have to provide a phone number.';

  /**
   * {@inheritdoc}
   */
  public function coversFields() {
    return [
      'phone',
      'mobile_phone',
    ];
  }
}
