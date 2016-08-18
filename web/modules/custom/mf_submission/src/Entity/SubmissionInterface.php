<?php

namespace Drupal\mf_submission\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Submission entities.
 *
 * @ingroup mf_submission
 */
interface SubmissionInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Submission type.
   *
   * @return string
   *   The Submission type.
   */
  public function getType();

  /**
   * Gets the Submission name.
   *
   * @return string
   *   Name of the Submission.
   */
  public function getName();

  /**
   * Sets the Submission name.
   *
   * @param string $name
   *   The Submission name.
   *
   * @return \Drupal\mf_submission\Entity\SubmissionInterface
   *   The called Submission entity.
   */
  public function setName($name);

  /**
   * Gets the Submission creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Submission.
   */
  public function getCreatedTime();

  /**
   * Sets the Submission creation timestamp.
   *
   * @param int $timestamp
   *   The Submission creation timestamp.
   *
   * @return \Drupal\mf_submission\Entity\SubmissionInterface
   *   The called Submission entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Submission published status indicator.
   *
   * Unpublished Submission are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Submission is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Submission.
   *
   * @param bool $published
   *   TRUE to set this Submission to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mf_submission\Entity\SubmissionInterface
   *   The called Submission entity.
   */
  public function setPublished($published);

}
