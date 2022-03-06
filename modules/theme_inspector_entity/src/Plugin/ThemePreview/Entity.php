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
final class Entity extends ThemePreviewPluginBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, private EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self($configuration, $plugin_id, $plugin_definition, $container->get('entity_type.manager'));
  }

  public function build(string $variation): array {

    /** @var \Drupal\theme_inspector_entity\Entity\EntityPreview $preview */
    $preview = $this->entityTypeManager
      ->getStorage('theme_inspector_entity_preview')
      ->load($this->getDerivativeId());

    $referenced_entity = $preview->getReferencedEntity();
    if (!$referenced_entity) {
      return ['#markup' => ''];
    }

    $view_builder = $this->entityTypeManager->getViewBuilder($preview->getReferencedEntityTypeId());
    return $view_builder->view($referenced_entity, $variation);
  }

}
