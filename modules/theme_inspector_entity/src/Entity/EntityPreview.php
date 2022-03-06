<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\theme_inspector_entity\EntityPreviewInterface;

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
 *     "uuid" = "uuid",
 *     "entity_type" = "entity_type",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "entity_uuid",
 *     "entity_type",
 *   }
 * )
 */
class EntityPreview extends ConfigEntityBase implements EntityPreviewInterface {

  protected string $id;
  protected string $label;
  protected ?string $entity_uuid;
  protected ?string $entity_type;

}
