<?php

namespace Drupal\mf_review\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Review entities.
 *
 * @ingroup mf_review
 */
interface ReviewInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Set name of review based on name and id of related submission form.
   *
   * @param string|null $form_label
   * @param int|null $form_id
   */
  public function autoName($form_label = NULL, $form_id = NULL);

  /**
   * Returns the submission entity to which the review is attached.
   *
   * @return \Drupal\mf_submission\Entity\SubmissionInterface
   *   The submission entity on which the review is attached.
   */
  public function getSubmissionEntity();

  /**
   * Returns the ID of the submission entity to which the review is attached.
   *
   * @return int
   *   The ID of the entity to which the comment is attached.
   */
  public function getSubmissionEntityId();


  /**
   * Gets the Review stage.
   *
   * @return \Drupal\state_machine\Plugin\Field\FieldType\StateItem
   *   The review StateItem entity.
   */
  public function getReviewStage();

  /**
   * Sets the Review stage.
   *
   * @param string $stage_name
   *   The machine name of the stage.
   *
   * @return \Drupal\mf_review\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setReviewStage($stage_name);

  /**
   * Gets the Review type.
   *
   * @return string
   *   The Review type.
   */
  public function getType();

  /**
   * Gets the Review name.
   *
   * @return string
   *   Name of the Review.
   */
  public function getName();

  /**
   * Sets the Review name.
   *
   * @param string $name
   *   The Review name.
   *
   * @return \Drupal\mf_review\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setName($name);

  /**
   * Gets the Review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Review.
   */
  public function getCreatedTime();

  /**
   * Sets the Review creation timestamp.
   *
   * @param int $timestamp
   *   The Review creation timestamp.
   *
   * @return \Drupal\mf_review\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Review published status indicator.
   *
   * Unpublished Review are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Review is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Review.
   *
   * @param bool $published
   *   TRUE to set this Review to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mf_review\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setPublished($published);

}
