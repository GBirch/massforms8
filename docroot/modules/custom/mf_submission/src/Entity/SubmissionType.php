<?php

namespace Drupal\mf_submission\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Submission type entity.
 *
 * @ConfigEntityType(
 *   id = "submission_type",
 *   label = @Translation("Submission type"),
 *   handlers = {
 *     "list_builder" = "Drupal\mf_submission\SubmissionTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\mf_submission\Form\SubmissionTypeForm",
 *       "edit" = "Drupal\mf_submission\Form\SubmissionTypeForm",
 *       "delete" = "Drupal\mf_submission\Form\SubmissionTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\mf_submission\SubmissionTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "submission_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "submission",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/submission_type/{submission_type}",
 *     "add-form" = "/admin/structure/submission_type/add",
 *     "edit-form" = "/admin/structure/submission_type/{submission_type}/edit",
 *     "delete-form" = "/admin/structure/submission_type/{submission_type}/delete",
 *     "collection" = "/admin/structure/submission_type"
 *   }
 * )
 */
class SubmissionType extends ConfigEntityBundleBase implements SubmissionTypeInterface {

  /**
   * The Submission type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Submission type label.
   *
   * @var string
   */
  protected $label;

}
