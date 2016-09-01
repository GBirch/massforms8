<?php

namespace Drupal\mf_review\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ReviewTypeForm.
 *
 * @package Drupal\mf_review\Form
 */
class ReviewTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $review_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $review_type->label(),
      '#description' => $this->t("Label for the Review type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $review_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\mf_review\Entity\ReviewType::load',
      ],
      '#disabled' => !$review_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $review_type = $this->entity;
    $status = $review_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Review type.', [
          '%label' => $review_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Review type.', [
          '%label' => $review_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($review_type->urlInfo('collection'));
  }

}
