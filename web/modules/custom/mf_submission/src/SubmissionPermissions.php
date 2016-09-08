<?php

namespace Drupal\mf_submission;

use Drupal\Core\Routing\UrlGeneratorTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\mf_submission\Entity\SubmissionType;

/**
 * Provides dynamic permissions for submissions of different types.
 * Adapted from NodePermissions.php.
 */
class SubmissionPermissions {

  use StringTranslationTrait;
  use UrlGeneratorTrait;

  /**
   * Returns an array of submission type permissions.
   *
   * @return array
   *   The submission type permissions.
   *   @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function submissionTypePermissions() {
    $perms = array();
    // Generate node permissions for all submission types.
    foreach (SubmissionType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of submission permissions for a given submission type.
   *
   * @param \Drupal\mf_submission\Entity\SubmissionType $type
   *   The node type.
   *
   * @return array
   *   An associative array of permission names and descriptions.
   */
  protected function buildPermissions(SubmissionType $type) {
    $type_id = $type->id();
    $type_params = array('%type_name' => $type->label());

    return array(
      "add $type_id submission" => array(
        'title' => $this->t('%type_name: Create new submission', $type_params),
      ),
      "edit own $type_id submission" => array(
        'title' => $this->t('%type_name: Edit own submissison', $type_params),
      ),
      "edit any $type_id submission" => array(
        'title' => $this->t('%type_name: Edit any submission', $type_params),
      ),
      "delete own $type_id submission" => array(
        'title' => $this->t('%type_name: Delete own submission', $type_params),
      ),
      "delete any $type_id submission" => array(
        'title' => $this->t('%type_name: Delete any submission', $type_params),
      ),
      "view $type_id submission revisions" => array(
        'title' => $this->t('%type_name: View revisions', $type_params),
      ),
      "revert $type_id submission revisions" => array(
        'title' => $this->t('%type_name: Revert revisions', $type_params),
        'description' => t('Role requires permission <em>view revisions</em> and <em>edit rights</em> for submissions in question, or <em>administer submissions</em>.'),
      ),
      "delete $type_id submission revisions" => array(
        'title' => $this->t('%type_name: Delete revisions', $type_params),
        'description' => $this->t('Role requires permission to <em>view revisions</em> and <em>delete rights</em> for submissions in question, or <em>administer submissions</em>.'),
      ),
    );
  }

}
