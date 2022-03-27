<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Example;

use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Register form preview.
 *
 * @ThemePreview(
 *   id = "node_form",
 *   label = @Translation("Node Form"),
 *   category = @Translation("Form Examples"),
 *   deriver = "Drupal\theme_inspector_form\Plugin\ThemePreview\Example\NodeFormDeriver",
 * )
 */
final class NodeForm extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    $node = self::getEntityTypeManager()
      ->getStorage('node')
      ->create(['type' => $variation]);
    return self::getEntityFormBuilder()->getForm($node);
  }

  private static function getEntityFormBuilder(): EntityFormBuilderInterface {
    return \Drupal::service('entity.form_builder');
  }

  private static function getEntityTypeManager(): EntityTypeManagerInterface {
    return \Drupal::entityTypeManager();
  }

}
