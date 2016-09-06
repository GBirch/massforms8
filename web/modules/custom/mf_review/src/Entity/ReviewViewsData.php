<?php

namespace Drupal\mf_review\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Review entities.
 */
class ReviewViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['review']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Review'),
      'help' => $this->t('The Review ID.'),
    );

    return $data;
  }

}
