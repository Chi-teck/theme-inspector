<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Plugin\ThemePreview;

use Drupal\Component\Plugin\Derivative\DeriverBase;

/**
 * Provides theme preview plugin definitions for entity previews.
 */
final class EntityDeriver extends DeriverBase {

  public function getDerivativeDefinitions($base_plugin_definition): array {

    $this->entityTypeManager = \Drupal::entityTypeManager();

    $previews = $this->entityTypeManager
      ->getStorage('theme_inspector_entity_preview')
      ->loadMultiple();

    $this->entityDisplayRepository = \Drupal::service('entity_display.repository');
    foreach ($previews as $preview) {
      $id = $preview->id();

      $view_modes = $this->entityDisplayRepository->getViewModeOptions($preview->getReferencedEntityTypeId());

      $this->derivatives[$id] = $base_plugin_definition;
      $this->derivatives[$id]['label'] = $preview->label();
      $this->derivatives[$id]['category'] = 'Entity / ' . $preview->getReferencedEntityTypeLabel();

      $this->derivatives[$id]['variations'] = $view_modes;
    }

    return $this->derivatives;
  }

}
