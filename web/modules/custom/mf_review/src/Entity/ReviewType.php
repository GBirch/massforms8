<?php

namespace Drupal\mf_review\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Review type entity.
 *
 * @ConfigEntityType(
 *   id = "review_type",
 *   label = @Translation("Review type"),
 *   handlers = {
 *     "list_builder" = "Drupal\mf_review\ReviewTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\mf_review\Form\ReviewTypeForm",
 *       "edit" = "Drupal\mf_review\Form\ReviewTypeForm",
 *       "delete" = "Drupal\mf_review\Form\ReviewTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\mf_review\ReviewTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "review_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "review",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/review_type/{review_type}",
 *     "add-form" = "/admin/structure/review_type/add",
 *     "edit-form" = "/admin/structure/review_type/{review_type}/edit",
 *     "delete-form" = "/admin/structure/review_type/{review_type}/delete",
 *     "collection" = "/admin/structure/review_type"
 *   }
 * )
 */
class ReviewType extends ConfigEntityBundleBase implements ReviewTypeInterface {

  /**
   * The Review type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Review type label.
   *
   * @var string
   */
  protected $label;

}
