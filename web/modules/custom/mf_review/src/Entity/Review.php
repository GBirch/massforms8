<?php

namespace Drupal\mf_review\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Review entity.
 *
 * @ingroup mf_review
 *
 * @ContentEntityType(
 *   id = "review",
 *   label = @Translation("Review"),
 *   bundle_label = @Translation("Review type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mf_review\ReviewListBuilder",
 *     "views_data" = "Drupal\mf_review\Entity\ReviewViewsData",
 *     "translation" = "Drupal\mf_review\ReviewTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\mf_review\Form\ReviewForm",
 *       "add" = "Drupal\mf_review\Form\ReviewForm",
 *       "edit" = "Drupal\mf_review\Form\ReviewForm",
 *       "delete" = "Drupal\mf_review\Form\ReviewDeleteForm",
 *     },
 *     "access" = "Drupal\mf_review\ReviewAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\mf_review\ReviewHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "review",
 *   data_table = "review_field_data",
 *   translatable = TRUE,
  *   admin_permission = "administer review entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/review/{review}",
 *     "add-page" = "/admin/structure/review/add",
 *     "add-form" = "/admin/structure/review/add/{review_type}",
 *     "edit-form" = "/admin/structure/review/{review}/edit",
 *     "delete-form" = "/admin/structure/review/{review}/delete",
 *     "collection" = "/admin/structure/review",
 *   },
 *   bundle_entity_type = "review_type",
 *   field_ui_base_route = "entity.review_type.edit_form"
 * )
 */
class Review extends ContentEntityBase implements ReviewInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * Set name of review based on name and id of related submission form.
   *
   * @param string|null $form_label
   * @param int|null $form_id
   */
  public function autoName($form_label = NULL, $form_id = NULL) {
    if ( !$form_label || !$form_id ) {
      $form = $this->getSubmissionEntity();
      $form_label = $form->getName();
      $form_id = $form->id();
    }
    $name = t('Review of form @id: @label', array('@id'=>$form_id, '@label' => $form_label));
    $this->setName($name);
  }

  public function setSubmissionID($id) {
    $this->set('submission_id', $id);
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmissionEntity() {
    return $this->get('submission_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmissionEntityId() {
    return $this->get('submission_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getReviewStage() {
    return $this->get('review_stage');
  }

  /**
   * {@inheritdoc}
   */
  public function setReviewStage($stage_name) {
    $this->set('review_stage', $stage_name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Review entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Review entity.'))
      ->setSettings(array(
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Review is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['submission_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Submission'))
      ->setDescription(t('The submission under review.'))
      ->setSetting('target_type', 'submission')
      ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['review_stage'] = BaseFieldDefinition::create('state')
      ->setLabel(t('Review Stage'))
      ->setDescription(t('The current stage of review of the related submission.'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    return $fields;
  }

  public static function bundleFieldDefinitions(EntityTypeInterface $entity_type, $bundle, array $base_field_definitions) {
    $review_type = ReviewType::load($bundle);
    if ($review_type) {
      // @TODO: Ability to set form type(s) per review type.
      $fields['review_stage'] = clone $base_field_definitions['review_stage'];
      $fields['review_stage']->setSetting('workflow', $review_type->getWorkflowName());
      return $fields;
    }
    return array();
  }

}
