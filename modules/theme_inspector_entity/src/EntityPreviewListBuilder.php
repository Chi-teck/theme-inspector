<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of entity previews.
 */
final class EntityPreviewListBuilder extends ConfigEntityListBuilder {

  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['label'] = $this->t('Label');
    $header['entity_type'] = $this->t('Entity type');
    $header['entity'] = $this->t('Entity');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $preview): array {
    /** @var \Drupal\theme_inspector_entity\EntityPreviewInterface $preview */
    $row['label'] = $preview->label();
    $row['id'] = $preview->id();
    $row['entity_type'] = $preview->get('entity_type');

    if ($entity_uuid = $preview->get('entity_uuid')) {
      $this->entityTypeManager = \Drupal::entityTypeManager();
      $entities = $this->entityTypeManager->getStorage($row['entity_type'])->loadByProperties(['uuid' => $entity_uuid]);
      if (\count($entities) > 0) {
        $entity = \reset($entities);
        $row['entity'] = $entity->toLink();
      }
    }

    return $row + parent::buildRow($preview);
  }

}
