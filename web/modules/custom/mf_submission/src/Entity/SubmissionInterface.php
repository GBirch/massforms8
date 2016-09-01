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
   * Constructs a name for the form.
   *
   * @param string $verb
   * @param null $timestamp
   */
  public function autoName($verb = 'created', $timestamp = NULL);

  /**
   * Retrieves the id of the review that relates to this form.
   *
   * @return int|null
   *   The id of the review, or NULL if not found.
   */
  public function getReviewId();

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
   * Gets the Submission submitted timestamp.
   *
   * @return int
   *   Submitted timestamp of the Submission.
   */
  public function getSubmittedTime();

  /**
   * Sets the Submission submitted timestamp.
   *
   * @param int $timestamp
   *   The Submission submitted timestamp.
   *
   * @return \Drupal\mf_submission\Entity\SubmissionInterface
   *   The called Submission entity.
   */
  public function setSubmittedTime($timestamp);

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
