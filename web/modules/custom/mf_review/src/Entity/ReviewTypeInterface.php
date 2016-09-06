<?php

namespace Drupal\mf_review\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Review type entities.
 */
interface ReviewTypeInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * @return string
   *    The machine name of the selected workflow
   */
  public function getWorkflowName();
}
