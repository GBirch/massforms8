<?php

namespace Drupal\mf_submission\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\mf_review\Entity\Review;

/**
 * Defines the Submission entity.
 *
 * @ingroup mf_submission
 *
 * @ContentEntityType(
 *   id = "submission",
 *   label = @Translation("Submission"),
 *   bundle_label = @Translation("Submission type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mf_submission\SubmissionListBuilder",
 *     "views_data" = "Drupal\mf_submission\Entity\SubmissionViewsData",
 *     "translation" = "Drupal\mf_submission\SubmissionTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\mf_submission\Form\SubmissionForm",
 *       "add" = "Drupal\mf_submission\Form\SubmissionForm",
 *       "edit" = "Drupal\mf_submission\Form\SubmissionForm",
 *       "delete" = "Drupal\mf_submission\Form\SubmissionDeleteForm",
 *     },
 *     "access" = "Drupal\mf_submission\SubmissionAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\mf_submission\SubmissionHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "submission",
 *   data_table = "submission_field_data",
 *   translatable = TRUE,
  *   admin_permission = "administer submission entities",
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
 *     "canonical" = "/admin/structure/submission/{submission}",
 *     "add-page" = "/admin/structure/submission/add",
 *     "add-form" = "/admin/structure/submission/add/{submission_type}",
 *     "edit-form" = "/admin/structure/submission/{submission}/edit",
 *     "delete-form" = "/admin/structure/submission/{submission}/delete",
 *     "collection" = "/admin/structure/submission",
 *   },
 *   bundle_entity_type = "submission_type",
 *   field_ui_base_route = "entity.submission_type.edit_form"
 * )
 */
class Submission extends ContentEntityBase implements SubmissionInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * Defaults the form to published state.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    // For the present, we are setting published to true on creation.
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
      'status' => 1,
    );
  }

  /**
   * {@inheritdoc}
   *
   * Sets the name and submitted timestamp of the form.
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    $submitted_time = $this->getSubmittedTime();
    // If newly published, set submitted timestamp and set/update the name of the submission.
    if ($this->isPublished() && empty($submitted_time)) {
      $this->setSubmittedTime($this->getChangedTime());
      $this->autoName('submitted', $this->getChangedTime());
    }
    // Otherwise, if new, set a name for it using defaults.
    elseif ($this->isNew()) {
      $this->autoName();
    }
    // Suspenders and belt: should never be run.
    elseif ( '' == $this->getName() ) {
      $verb = $this->isPublished() ? 'submitted' : 'created';
      if ( $submitted_time ) {
        $timestamp = $submitted_time;
      } else {
        $timestamp = $this->isPublished() ? $this->getChangedTime() : $this->getCreatedTime();
      }
      $this->autoName($verb, $timestamp);
      \Drupal::logger('MassForms Submission')->error('Name supplied for submission %id when it should have had one already', array('@id'=>$this->id()));
    }
  }

  /**
   * {@inheritdoc}
   *
   * Creates the related review if submission is new.
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

    if ( !$update ) {
      // TODO: need to have a more intelligent way to specify which kind of review to create.
      $review_bundle = 'demo_workflow';

      $review = Review::create(array(
        'user_id' => 1,
        'status' => $this->isPublished(),
        'submission_id' => $this->id(),
        'type' => $review_bundle,
        'review_stage' => $this->isPublished() ? 'submitted' : 'draft',
      ));
      $review->autoName($this->getName(), $this->id());
      $review->save();
    }
    // Consider checking for related review and re-connect form to review if link is broken.

  }

  /**
   * {@inheritdoc}
   */
  public function autoName($verb = 'created', $timestamp = NULL) {
    if ( empty($timestamp) ) {
      $timestamp = REQUEST_TIME;
    }
    $verb = t($verb);
    $name = $this->type->entity->label() . " $verb " . \Drupal::service('date.formatter')->format($timestamp);
    $this->setName($name);
  }

  /**
   * {@inheritdoc}
   */
  public function getReviewId() {
    $review_ids = \Drupal::entityQuery('review')
      ->condition('submission_id', $this->id())
      ->execute();
    if ( !empty($review_ids) ) {
      return current($review_ids);
    }
    return NULL;
  }


  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
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
  public function getSubmittedTime() {
    return $this->get('submitted')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubmittedTime($timestamp) {
    $this->set('submitted', $timestamp);
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
      ->setLabel(t('Submitted by'))
      ->setDescription(t('The user ID of the author of the Submission entity.'))
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
      ->setDescription(t('The name of the Submission entity.'))
      ->setSettings(array(
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'hidden',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Submitted status'))
      ->setDescription(t('A boolean indicating whether the Submission is submitted.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the submission was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the submission was last edited.'));

    $fields['submitted'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Submitted'))
      ->setDescription(t('The time that the submission was submitted.'))
      ->setDisplayOptions('view', array(
        'label' => 'inline',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
