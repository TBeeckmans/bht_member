<?php

namespace Drupal\bht_member;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Field\FieldItemList;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\TypedData\ComputedItemListTrait;
use Drupal\Core\Url;

/**
 * A computed property for publishing the users email with their consent.
 */
class PublishedEmail extends FieldItemList {

  use ComputedItemListTrait;

  public function access($operation = 'view', AccountInterface $account = NULL, $return_as_object = FALSE) {
    if (!$account) {
      $account = \Drupal::currentUser();
    }

    if (count(array_diff($account->getRoles(), ['webadmin', 'administrator'])) != count($account->getRoles())) {
      return AccessResult::allowed();
    }

    $entity = $this->getParent()->getEntity();
    $consent = $entity->get('email_consent')->getString();
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
   * Computes the calculated values for this item list listing the email.
   */
  protected function ensurePopulated() {
    if (!isset($this->list[0])) {
      /* @var $entity \Drupal\user\Entity\User */
      $entity = $this->getParent()->getEntity();
      $this->list[0] = $this->createItem(0, Link::fromTextAndUrl($entity->getEmail(), Url::fromUri('mailto:' . $entity->getEmail()))->toString());
    }
  }

}
