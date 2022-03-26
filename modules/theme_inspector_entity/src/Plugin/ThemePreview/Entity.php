<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Plugin\ThemePreview;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Entity preview.
 *
 * @ThemePreview(
 *   id = "entity",
 *   deriver = "Drupal\theme_inspector_entity\Plugin\ThemePreview\EntityDeriver",
 * )
 */
final class Entity extends ThemePreviewPluginBase {

  public function build(string $variation): array {

    $entity_type_manager = self::getEntityTypeManager();
    /** @var \Drupal\theme_inspector_entity\Entity\EntityPreview $preview */
    $entity_type_manager
      ->getStorage('theme_inspector_entity_preview')
      ->load($this->getDerivativeId());

    $referenced_entity = $preview->getReferencedEntity();
    if (!$referenced_entity) {
      return ['#markup' => $this->t('Could not load entity.')];
    }

    $view_builder = $entity_type_manager->getViewBuilder($preview->getReferencedEntityTypeId());
    return $view_builder->view($referenced_entity, $variation);
  }

  private static function getEntityTypeManager(): EntityTypeManagerInterface {
    return \Drupal::entityTypeManager();
  }

}
