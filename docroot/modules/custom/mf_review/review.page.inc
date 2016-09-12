<?php

/**
 * @file
 * Contains review.page.inc.
 *
 * Page callback for Review entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Review templates.
 *
 * Default template: review.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_review(array &$variables) {
  // Fetch Review Entity Object.
  $review = $variables['elements']['#review'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
