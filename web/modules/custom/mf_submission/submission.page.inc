<?php

/**
 * @file
 * Contains submission.page.inc.
 *
 * Page callback for Submission entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Submission templates.
 *
 * Default template: submission.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_submission(array &$variables) {
  // Fetch Submission Entity Object.
  $submission = $variables['elements']['#submission'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
