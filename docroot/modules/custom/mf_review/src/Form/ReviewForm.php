<?php

namespace Drupal\mf_review\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\mf_submission\Entity\Submission;

/**
 * Form controller for Review edit forms.
 *
 * @ingroup mf_review
 */
class ReviewForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    /* @var $entity \Drupal\mf_review\Entity\Review */


    // Disable the submission_id field widget.
    $form['submission_id']['widget']['#access'] = FALSE;

    // And add a rendered view of the submission.
    /** @var Submission $submission */
    $submission = $this->entity->get('submission_id')->entity;
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('submission');
    // TODO: We could customize the display of the submission depending on the current state of the Review.
    $render_array = $view_builder->view($submission, 'default');
    $form['submission_id']['rendered'] = $render_array;


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Review.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Review.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.review.canonical', ['review' => $entity->id()]);
  }

}
