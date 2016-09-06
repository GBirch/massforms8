<?php

namespace Drupal\mf_review;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Review entity.
 *
 * @see \Drupal\mf_review\Entity\Review.
 */
class ReviewAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mf_review\Entity\ReviewInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished review entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published review entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit review entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete review entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add review entities');
  }

}
