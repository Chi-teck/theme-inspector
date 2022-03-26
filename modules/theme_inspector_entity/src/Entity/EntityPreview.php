<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Defines the entity preview entity type.
 *
 * @ConfigEntityType(
 *   id = "theme_inspector_entity_preview",
 *   label = @Translation("Entity Preview"),
 *   label_collection = @Translation("Entity Previews"),
 *   label_singular = @Translation("entity preview"),
 *   label_plural = @Translation("entity previews"),
 *   label_count = @PluralTranslation(
 *     singular = "@count entity preview",
 *     plural = "@count entity previews",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\theme_inspector_entity\EntityPreviewListBuilder",
 *     "form" = {
 *       "add" = "Drupal\theme_inspector_entity\Form\EntityPreviewForm",
 *       "edit" = "Drupal\theme_inspector_entity\Form\EntityPreviewForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "theme_inspector_entity_preview",
 *   admin_permission = "administer theme_inspector_entity_preview",
 *   links = {
 *     "collection" = "/admin/config/development/theme-inspector/entity",
 *     "add-form" = "/admin/config/development/theme-inspector/entity/add",
 *     "edit-form" = "/admin/config/development/theme-inspector/entity/{theme_inspector_entity_preview}",
 *     "delete-form" = "/admin/config/development/theme-inspector/entity/{theme_inspector_entity_preview}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "entity_uuid",
 *     "entity_type_id",
 *   }
 * )
 */
final class EntityPreview extends ConfigEntityBase {

  use StringTranslationTrait;

  protected string $id;
  protected string $label;
  protected ?string $entity_uuid;
  protected string $entity_type_id;

  public function getReferencedEntity(): ?EntityInterface {
    if ($this->entity_uuid === NULL) {
      return NULL;
    }

    if (!$this->entityTypeManager()->hasDefinition($this->entity_type_id)) {
      return NULL;
    }

    $entities = $this->entityTypeManager()
      ->getStorage($this->entity_type_id)
      ->loadByProperties(['uuid' => $this->entity_uuid]);

    return \count($entities) > 0 ? \reset($entities) : NULL;
  }

  public function getReferencedEntityTypeId(): string {
    return $this->get('entity_type_id');
  }

  public function getReferencedEntityTypeLabel(): string {
    $entity_type_definition = $this->entityTypeManager()->getDefinition($this->get('entity_type_id'), FALSE);
    $label = $entity_type_definition ? $entity_type_definition->getLabel() : $this->t('Broken');
    return (string) $label;
  }

}
