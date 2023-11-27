<?php
use Drupal\views\Entity\View;

/**
 * Implements hook_views_data().
 */
function actualites_filtre_views_data(): array {
  $data = [];

  $data['node']['custom_filter'] = [
    'title' => t('Mon filtre personnalisé'),
    'filter' => [
      'title' => t('Mon filtre personnalisé'),
      'help' => t('Description de ce que fait le filtre.'),
      'id' => 'actualites_taxonomie_term',
      'allow empty' => TRUE,
      'missing behavior' => ['hide row' => TRUE],
    ],
    'argument' => [
      'id' => 'actualites_taxonomie_term',
    ],
  ];

  return $data;
}
