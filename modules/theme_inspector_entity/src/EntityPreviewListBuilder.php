<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\theme_inspector_entity\Entity\EntityPreview;

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

  public function buildRow(EntityInterface|EntityPreview $preview): array {
    $row['label'] = $preview->label();
    $row['id'] = $preview->id();
    $row['entity_type'] = $preview->getReferencedEntityTypeLabel();
    $row['entity'] = NULL;
    if ($referenced_entity = $preview->getReferencedEntity()) {
      $row['entity'] = $referenced_entity->hasLinkTemplate('canonical')
        ? $referenced_entity->toLink() : $referenced_entity->label();
    }
    return $row + parent::buildRow($preview);
  }

}
