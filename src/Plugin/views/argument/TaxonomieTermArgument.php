<?php

namespace Drupal\actualites_filtre\Plugin\views\argument;

use Drupal\actualites_filtre\Event\ViewsQuerySubstitutionEvent;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\views\Plugin\views\argument\ArgumentPluginBase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Plugin de traitement des arguments de termes de taxonomie pour les vues.
 *
 * @ViewsArgument("actualites_taxonomie_term")
 */
class TaxonomieTermArgument extends ArgumentPluginBase {



  // Injectez l'EventDispatcher dans votre classe si ce n'est pas déjà fait.

  /**
   * Méthode pour traiter l'argument.
   */
  public function query($group_by = FALSE) {
    // Dans votre plugin de vue (query)
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path)[2];
    try {
      $terms = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->loadByProperties(['name' => $path_args]);

      if (!empty($terms)) {
        $term = reset($terms);

        // Get the term ID and apply as a filter.
        $term_id = $term->id();

        // Add a condition to the view query.
        // Use the node__field_type_d_actu table and the field_type_d_actu_target_id field.
        $this->query->addWhere('condition_group', 'node__field_type_d_actu.field_type_d_actu_target_id', $term_id, '=');      }
    } catch (InvalidPluginDefinitionException|PluginNotFoundException $e) {
      // Handle exceptions here
    }
  }
}
