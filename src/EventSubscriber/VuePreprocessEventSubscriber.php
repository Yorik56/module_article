<?php

namespace Drupal\actualites_filtre\EventSubscriber;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\views_event_dispatcher\ViewsHookEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreExecuteEvent;

class VuePreprocessEventSubscriber implements EventSubscriberInterface {
  private $parameterBag;

  public function __construct(ParameterBagInterface $parameterBag) {
    $this->parameterBag = $parameterBag;
  }
  public static function getSubscribedEvents(): array {
    $events[ViewsHookEvents::VIEWS_PRE_EXECUTE][] = ['onViewsPreExecute', 0];
    return $events;
  }

  public function onViewsPreExecute(ViewsPreExecuteEvent $event) {

    $view = $event->getView();
    if ($view->id() == 'articles') {
      $taxonomie_term = $this->getParameter();
      if ($taxonomie_term) {
        // Stockez le terme dans le ParameterBag.
        $this->parameterBag->set('custom_taxonomie_term.term_name', $taxonomie_term);
      } else {
        // Logique si aucun terme de taxonomie n'est présent.
        // ...
      }
    }
  }

  private function getParameter() {
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);

    // Supposons que le terme de taxonomie soit toujours le troisième segment de l'URL.
    return $path_args[2] ?? null;
  }
}
