<?php

namespace Drupal\bht_member;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Field\FieldItemList;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\TypedData\ComputedItemListTrait;

/**
 * A computed property for publishing the users name with their consent.
 */
class PublishedName extends FieldItemList {

  use ComputedItemListTrait;

  public function access($operation = 'view', AccountInterface $account = NULL, $return_as_object = FALSE) {
    if (!$account) {
      $account = \Drupal::currentUser();
    }

    if (count(
        array_diff($account->getRoles(), [
          'webadmin',
          'administrator',
        ])
      ) != count($account->getRoles())) {
      return AccessResult::allowed();
    }

    $entity = $this->getParent()->getEntity();
    $consent = $entity->get('publication_consent')->getString();
    if (!$consent) {
      return AccessResult::forbidden();
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function computeValue() {
    $this->ensurePopulated();
  }

  /**
   * Computes the calculated value for this item list as first and last name.
   */
  protected function ensurePopulated() {
    if (!isset($this->list[0])) {
      $name = [];
      $entity = $this->getParent()->getEntity();
      $name[] = $entity->get('firstname')->getString();
      $name[] = $entity->get('lastname')->getString();
      $this->list[0] = $this->createItem(0, implode(' ', $name));
    }
  }
}
