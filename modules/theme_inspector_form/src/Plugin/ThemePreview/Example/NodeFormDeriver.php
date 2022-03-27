<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Example;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides theme preview plugin definitions for node form previews.
 */
final class NodeFormDeriver extends DeriverBase {

  public function getDerivativeDefinitions($base_plugin_definition): array {

    $entity_type_manager = self::getEntityTypeManager();

    // Node module may not be installed.
    if (!$entity_type_manager->hasDefinition('node_type')) {
      return [];
    }

    $types = $entity_type_manager->getStorage('node_type')->loadMultiple();
    if (\count($types) === 0) {
      return [];
    }

    $id = $base_plugin_definition['id'];
    $this->derivatives[$id] = $base_plugin_definition;
    foreach ($types as $type) {
      $this->derivatives[$id]['variations'][$type->id()] = $type->label();
    }

    return $this->derivatives;
  }

  private static function getEntityTypeManager(): EntityTypeManagerInterface {
    return \Drupal::entityTypeManager();
  }

}
