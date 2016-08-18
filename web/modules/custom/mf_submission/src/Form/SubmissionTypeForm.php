<?php

namespace Drupal\mf_submission\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SubmissionTypeForm.
 *
 * @package Drupal\mf_submission\Form
 */
class SubmissionTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $submission_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $submission_type->label(),
      '#description' => $this->t("Label for the Submission type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $submission_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\mf_submission\Entity\SubmissionType::load',
      ],
      '#disabled' => !$submission_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $submission_type = $this->entity;
    $status = $submission_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Submission type.', [
          '%label' => $submission_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Submission type.', [
          '%label' => $submission_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($submission_type->urlInfo('collection'));
  }

}
