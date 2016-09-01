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
