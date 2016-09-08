<?php

namespace Drupal\mf_submission;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Submission entity.
 *
 * @see \Drupal\mf_submission\Entity\Submission.
 */
class SubmissionAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mf_submission\Entity\SubmissionInterface $entity */

    // Fetch information from the submission object if possible.
    $status = $entity->isPublished();
    $uid = $entity->getOwnerId();
    $user_is_author = ($account->isAuthenticated() && $account->id() == $uid);
//    $type_id = $entity->getType();

    // Submission permissions are oriented around ownership.
    switch ($operation) {
      case 'view':
        if ($user_is_author) {
          $result = AccessResult::allowedIfHasPermission($account, 'view own submissions');
          if ($result->isAllowed()) {
            return $result;
          }
        }
        // For non-authors, permission depends on published status.
        if (!$status) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished submissions');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published submissions');

      case 'update':
        if ($user_is_author) {
          $result = AccessResult::allowedIfHasPermission($account, 'edit own submissions');
          if ($result->isAllowed()) {
            return $result;
          }
        }
        return AccessResult::allowedIfHasPermission($account, 'edit submissions');

      case 'delete':
        if ($user_is_author) {
          $result = AccessResult::allowedIfHasPermission($account, 'delete own submissions');
          if ($result->isAllowed()) {
            return $result;
          }
        }
        return AccessResult::allowedIfHasPermission($account, 'delete submissions');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add submissions');
  }

}
