<?php

namespace Drupal\mf_submission\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Submission entities.
 */
class SubmissionViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['submission']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Submission'),
      'help' => $this->t('The Submission ID.'),
    );

    return $data;
  }

}
