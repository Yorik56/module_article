<?php

namespace Drupal\actualites_filtre\Controller;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ActualitesController extends ControllerBase {

  protected $entityTypeManager;

  protected RendererInterface $renderer;

  public function __construct(EntityTypeManagerInterface $entityTypeManager, RendererInterface $renderer) {
    $this->entityTypeManager = $entityTypeManager;
    $this->renderer = $renderer;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

  /**
   * Afficher la page de base.
   *
   * @throws \Exception
   */
  public function afficherPageBase($taxonomie_term) {
    // Charger un nœud spécifique par son ID.
    $nid = 6; // Remplacez 1 par l'ID du nœud que vous souhaitez afficher.
    $node = Node::load($nid);

    if ($node) {
      // Rendre le nœud en utilisant la vue coomplète.
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');
      $build = $view_builder->view($node, 'full');

      // Créer une réponse HTTP avec le rendu du nœud.
      return $build;
    }

    return [
      '#markup' => $this->t('Contenu introuvable'),
    ];
  }

}
